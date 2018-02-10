<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/9
 * Time: 11:45
 */

namespace App\Console\Commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    public function configure()
    {
        $this->setName('test')->setDescription('测试示范');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        dump("OK");
    }
}