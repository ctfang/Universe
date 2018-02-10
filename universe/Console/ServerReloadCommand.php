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

class ServerReloadCommand extends Command
{
    public function configure()
    {
        $this->setName('reload')->setDescription('重启服务');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $pid_file = App::get('config')->get('server.http.set.pid_file');

        if( !file_exists($pid_file) || !$pid = file_get_contents($pid_file) ){
            $output->writeln("<error>pid日记文件不存在，手动删除</error>");
            exit(1);
        }

        if( posix_kill($pid, SIGUSR1) ){
            $output->writeln("<info>重启成功{$pid}</info>");
        }else{
            $output->writeln("<error>重启失败{$pid}</error>");
        }
    }
}