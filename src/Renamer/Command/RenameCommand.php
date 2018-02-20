<?php
namespace Renamer\Command;

use Renamer\Service\RenamerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;

/**
 * A console command that renames files and directories.
 *
 * To use this command, open a terminal window and execute the following:
 *
 *     $ php bin/console renamer:rename
 *
 * To output detailed information, increase the command verbosity:
 *
 *     $ php bin/console renamer:rename -vv
 */
class RenameCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('renamer:rename')
            ->setDescription('Renames files and directories.')
            ->setHelp('This command allows you to rename files and directories...')
            ->addArgument('config', InputArgument::REQUIRED, 'The location of the config file.')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->readConfigFile($input->getArgument('config'));

        if (isset($config->renamers)) {
            foreach ($config->renamers as $renamer) {
                $service = new RenamerService($renamer, $this->io);
                $service->run();

            }
        }
    }

    protected function readConfigFile($path)
    {
        $config = Yaml::parseFile($path, Yaml::PARSE_OBJECT_FOR_MAP);

        if (isset($config->renamers)) {
            foreach ($config->renamers as &$renamer) {
                if (!isset($renamer->root)) {
                    $renamer->root = $config->root;
                }
            }
        }

        if (isset($config->validators)) {
            foreach ($config->validators as &$validator) {
                if (!isset($validator->root)) {
                    $validator->root = $config->root;
                }
            }
        }

        return $config;
    }
}
