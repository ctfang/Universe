这是一个基于swoole扩展的php框架，可以无缝运行在swoole_server模式和nginx+fpm模式，所以可以在nginx+fpm模式下开发调试，享受php语言的便捷开发，生产环境又可以拥有swoole常住内存带来的性能；本框架大量参考了laravel、和phalcon框架的功能实现，例如框架骨架使用了DI服务，所有框架先注册进入DI树，注册完后才使用，这样可以更好的扩展框架功能，哪怕是覆盖框架核心服务都行。完整的copy了laravel的路由(route)和中间件(middleware)。因为universe是常住内存运行的，所以DI服务都是一次注册多次使用，不会频繁操作IO，以实现高性能。

<p align="">
<a href="https://packagist.org/packages/selden1992/Universe"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/selden1992/Universe"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Universe

> **Note:** Universe的目标是所有注册进di的服务都由第三方开发，让更多的人参与进来

## 已经实现的功能列表

<details>
    <summary>安装使用</summary>
    
- fpm模式:   配置nginx到项目/public目录
- swoole模式:进入项目更目录运行 php server.php
    
</details>