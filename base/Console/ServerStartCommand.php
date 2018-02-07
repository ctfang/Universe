<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/7
 * Time: 15:58
 */

namespace Universe\Console;


use Swoole\Http\Server;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Universe\App;

class ServerStartCommand extends Command
{
    /**
     * @var Server
     */
    private $app;

    public function __construct($app = null)
    {
        parent::__construct(null);
        $this->app = $app;
    }

    public function configure()
    {
        $this->setName('start')
            ->addOption('daemonize', null, InputOption::VALUE_OPTIONAL, '守护进程启动', false)
            ->setDescription('启动服务,默认调试模式启动');


    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $daemonize = $input->getOption('daemonize');
        if ($daemonize === false) {
            $daemonize = 0;
        } else {
            $daemonize = 1;
        }
        $config = App::getShared('config');
        $serverConfig = $config->get('server');
        $serverConfig['set']['daemonize'] = $daemonize;
        $config->set('server', $serverConfig);

        $output->writeln("<info>启动配置</info>");

        $table = array_merge($serverConfig['http'],$serverConfig['set']);
        $list  = [];
        foreach ($table as $key=>$value){
            switch ($key){
                case 'host':
                    $temp = ["监听域名",$value];
                    break;
                case 'port':
                    $temp = ["监听端口",$value];
                    break;
                case 'daemonize':
                    $temp = ["守护模式",$value==1?"是":"否"];
                    break;
                default:
                    $temp = [$key,$value];
                    break;
            }
            $list[] = $temp;
        }

        $io = new SymfonyStyle($input, $output);
        $io->table(['配置key','值'], $list);

        unset($io,$list,$input,$output,$temp,$daemonize,$config,$serverConfig);
        $this->app->start();
    }
}