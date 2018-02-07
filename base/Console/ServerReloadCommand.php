<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/7
 * Time: 16:07
 */

namespace Universe\Console;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ServerReloadCommand extends Command
{
    public function configure()
    {
        $this->setName('reload')->setDescription('重启服务');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {

    }
}