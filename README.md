这是一个基于swoole扩展的php框架，调试模式下代码跟普通php-fpm模式一样，是实时生效的；框架部分大量参考了phalcon和laravel代码的实现，例如框架骨架使用了DI服务，所有框架先注册进入DI树，注册完后才使用，这样可以更好的扩展框架功能，哪怕是覆盖框架核心服务都行。因为universe是常住内存运行的，所以DI服务都是一次注册多次使用。

<p align="">
<a href="https://packagist.org/packages/ctfang/Universe"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/ctfang/Universe"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Universe

2.0.* 版本已经抛弃fpm模式运行，调试模式可以自动reload，实现代码实时生效

> **Note:** Universe的目标是所有注册进di的服务都由第三方开发，让更多的人参与开发


## 已经实现的功能列表

<details open="open">
    <summary>安装使用</summary>
    
composer安装
~~~~
composer create-project ctfang/universe
~~~~
git安装
~~~~
git clone https://github.com/ctfang/Universe.git
cd Universe
composer install
~~~~
运行，单独运行php server有帮助命令
~~~~php
// 守护模式，调试下支持代码更改实时生效
php server start
// 非守护模式
php server start --daemonize=0
// 重启服务
php server reload
php server stop
~~~~
启动时，会输出域名端口基本信息
~~~~
 ----------------- -------------------------------------------------------
  配置key           值
 ----------------- -------------------------------------------------------
  监听域名          0.0.0.0
  监听端口          8081
  log_file          /data/webpages/swoole-demo/storage/swoole.log
  pid_file          /data/webpages/swoole-demo/bootstrap/cache/server.pid
  log_level         5
  worker_num        4
  task_worker_num   0
  守护模式          是
 ----------------- -------------------------------------------------------

~~~~

如果需要访问静态资源，html、css、js等；可以配置nginx服务器，配置模板
bootstrap\swoole.app.conf
~~~~
server {
    listen       80;
    server_name  demo.app;

    root /data/webpages/swoole-demo/public;

    index index.html;

    location / {
        try_files $uri @swoole;
    }

    location @swoole {
        proxy_http_version 1.1;
        proxy_set_header Connection "keep-alive";
        proxy_set_header X-Real-IP $remote_addr;
        proxy_pass http://php:8081;
    }
}
~~~~

    
</details>

<details>
    <summary>代码即时生效</summary>
    
借助中间件，在所有业务处理完后，向server发起reload，新的请求就运行新的代码。
注入di的服务不会立即更新
    
</details>

<details>
    <summary>配置载入</summary>
    
所有的配置都在config目录下，默认加载配置文件
~~~~
universe/config/app.php
~~~~
    
</details>

<details open="open">
    <summary>控制器</summary>

一个基础的控制器定义
    
~~~~php
namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function getString()
    {
        return '输出字符串;获取请求参数:'.$this->request->get('id','int',0);
    }

    public function getJson()
    {
        return [
            'time'=>time(),
            'string'=>'响应json格式，自动加Json Header',
        ];
    }
}
~~~~

访问上面示范两个函数需要添加路由，路由文件在 /config/route.php
    
~~~~php
Route::get('/string', 'IndexController@getString');
Route::get('/index/json', 'IndexController@getJson');
~~~~

路由器访问   http://test.test/index/json  就可以进入  getJson

</details>

<details open="open">
    <summary>路由</summary>
    
所有接口都必须在路由文件/config/route.php注册
~~~~php
Route::get('/string', 'IndexController@getString');
Route::get('/index/json', 'IndexController@getJson');

// 注册一个分组，分组内的路由都会添加 /test 前缀
// middleware参数是所有请求都会进入login中间件，例如实现/test开头的路由都必须登录后才能访问
Route::group(['prefix' => '/test', 'middleware' => 'login'],function () {
    Route::get('/one', 'IndexController@one');
    Route::get('/two', 'IndexController@two');
});
~~~~

</details>

<details open="open">
    <summary>中间件</summary>
    
中间的使用基本和laravel一模一样，中间件在控制器前还是后执行，是有中间件本身决定的，所有中间件都在目录/app/http/middleware下

~~~~php
namespace App\Http\Middleware;


use Universe\Support\Middleware;
use Universe\Servers\RequestServer;

class AuthMiddleware extends Middleware
{
    /**
     * @param RequestServer $request
     * @param $next
     */
    public function handle(RequestServer $request, $next)
    {
        // 这里的代码在控制器前运行
        
        $response = $next($request);
        
        // 这里的代码在控制器后运行
        
        return $response;
    }
}
~~~~
完全由 $next($request) 决定中间件的运行前后。

当然中间一般都用来权限校验或者重定向等。
~~~~php
class AuthMiddleware extends Middleware
{
    /**
     * @param RequestServer $request
     * @param $next
     */
    public function handle(RequestServer $request, $next)
    {
        if( !is_login() ){
            // 没有登录重定向到登陆页面
            $request->setUri('/login');
            // 需要重新向新地址，返回 新地址 对象即可
            return $request;
        }
        
        if( !$request->get('token') ){
            /**
             * 需要验证token的接口，没有参数
             * 返回数组，获取字符串，就可以停止执行
             */
            return [
                'error'=>'403',
                'error_msg'=>'没有权限',
            ];
        }
        // 可以进入控制器
        return $next($request);
    }
}
~~~~

    
</details>

<details>
    <summary>异常服务</summary>
    
/app/Exceptions/Kernel.php 注册异常需要经过的handler
~~~~php
class Kernel extends ExceptionKernel
{
    /**
     * 注册异常处理
     *
     * @return mixed
     * @author 明月有色 <2206582181@qq.com>
     */
    public function register()
    {
        if( is_debug() ){
            // 如果调试，把错误展示出来
            $this->server->pushHandler(new PrettyPageHandler());
        }
        // 所有错误日记记录
        $this->server->pushHandler(new LoggerHandler());
        // 404 优先处理
        $this->server->pushHandler(new NotFoundHandler());
    }
}
~~~~
上面注册了3个handler

- 把所有错误写入日记
- 把错误显示出来
- 404展示一个简单页面
    
</details>

<details>
    <summary>数据模型</summary>
    
~~~~php
dump(DB::table('test')->find(1));
User::find(1);l
~~~~
使用上完全跟laravel一样，因为集成的是相同的composer包，如果需要用其他的orm，重新注册DI即可
    
</details>


<details>
    <summary>事件系统</summary>

~~~~php
App::get('events')
~~~~
</details>

<details>
    <summary>数据迁移</summary>

输入命令查看帮助,集成phinx
~~~~php
php moon
~~~~
</details>


连接池，如果需要orm默认使用连接池执行，可以在database注入时，传入新的Connection
默认Connection在 /illuminate/database/Connection.php
新Connection继承/illuminate/database/Connection.php，并且参考651行runQueryCallback函数

## 如何加入开发组

- 提交commit，例如开发一个非常漂亮的异常 handler处理
- 给已有的成员发送邮件 

## 开发组

- [x] [明月有色](https://blog.ctfang.com) 
- [x] [白色白色T恤](https://github.com/caojiabin2012) 
- [ ] 等待你的加入