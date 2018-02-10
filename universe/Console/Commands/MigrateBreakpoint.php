<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/10
 * Time: 15:00
 */

namespace Universe\Console\Commands;


use Phinx\Console\Command\Breakpoint;
use Symfony\Component\Console\Input\InputOption;

class MigrateBreakpoint extends Breakpoint
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->addOption('--configuration', '-c', InputOption::VALUE_REQUIRED, 'The configuration file to load',__DIR__.'/../../Migrate/phinx.php');
        $this->addOption('--parser', '-p', InputOption::VALUE_REQUIRED, 'Parser used to read the config file. Defaults to YAML');

        $this->addOption('--environment', '-e', InputOption::VALUE_REQUIRED, 'The target environment.');

        $this->setName('migrate:breakpoint')
            ->setDescription('Manage breakpoints')
            ->addOption('--target', '-t', InputOption::VALUE_REQUIRED, 'The version number to set or clear a breakpoint against')
            ->addOption('--remove-all', '-r', InputOption::VALUE_NONE, 'Remove all breakpoints')
            ->setHelp(
                <<<EOT
The <info>breakpoint</info> command allows you to set or clear a breakpoint against a specific target to inhibit rollbacks beyond a certain target.
If no target is supplied then the most recent migration will be used.
You cannot specify un-migrated targets

<info>phinx breakpoint -e development</info>
<info>phinx breakpoint -e development -t 20110103081132</info>
<info>phinx breakpoint -e development -r</info>
EOT
            );
    }
}