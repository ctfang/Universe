<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/10
 * Time: 15:01
 */

namespace Universe\Console\Commands;


use Phinx\Console\Command\SeedCreate;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MigrateSeedCreateCommand extends SeedCreate
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->addOption('--configuration', '-c', InputOption::VALUE_REQUIRED, 'The configuration file to load',__DIR__.'/../../Migrate/phinx.php');
        $this->addOption('--parser', '-p', InputOption::VALUE_REQUIRED, 'Parser used to read the config file. Defaults to YAML');

        $this->setName('seed:create')
            ->setDescription('Create a new database seeder')
            ->addArgument('name', InputArgument::REQUIRED, 'What is the name of the seeder?')
            ->addOption('path', null, InputOption::VALUE_REQUIRED, 'Specify the path in which to create this seeder')
            ->setHelp(sprintf(
                          '%sCreates a new database seeder%s',
                          PHP_EOL,
                          PHP_EOL
                      ));
    }
}