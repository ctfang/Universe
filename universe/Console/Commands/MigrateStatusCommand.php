<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/10
 * Time: 14:59
 */

namespace Universe\Console\Commands;


use Phinx\Console\Command\Status;
use Symfony\Component\Console\Input\InputOption;

class MigrateStatusCommand extends Status
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->addOption('--configuration', '-c', InputOption::VALUE_REQUIRED, 'The configuration file to load',__DIR__.'/../../Migrate/phinx.php');
        $this->addOption('--parser', '-p', InputOption::VALUE_REQUIRED, 'Parser used to read the config file. Defaults to YAML');

        $this->addOption('--environment', '-e', InputOption::VALUE_REQUIRED, 'The target environment.');

        $this->setName('migrate:status')
            ->setDescription('Show migration status')
            ->addOption('--format', '-f', InputOption::VALUE_REQUIRED, 'The output format: text or json. Defaults to text.')
            ->setHelp(
                <<<EOT
The <info>status</info> command prints a list of all migrations, along with their current status

<info>phinx status -e development</info>
<info>phinx status -e development -f json</info>

The <info>version_order</info> configuration option is used to determine the order of the status migrations.
EOT
            );
    }
}