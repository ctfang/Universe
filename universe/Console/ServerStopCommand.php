<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/7
 * Time: 16:07
 */

namespace Universe\Console;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Universe\App;

class ServerStopCommand extends Command
{
    public function configure()
    {
        $this->setName('stop')->setDescription('停止服务');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $pid_file = App::get('config')->get('server.http.set.pid_file');

        if( !file_exists($pid_file) || !$pid = file_get_contents($pid_file) ){
            $output->writeln("<error>pid日记文件不存在，手动删除</error>");
            exit(1);
        }

        if( posix_kill($pid, SIGTERM) ){
            $output->writeln("<info>停止成功{$pid}</info>");
        }else{
            $output->writeln("<error>停止失败{$pid}</error>");
        }
    }
}