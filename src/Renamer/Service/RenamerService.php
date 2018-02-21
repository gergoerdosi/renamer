<?php
namespace Renamer\Service;

use Renamer\Service\ServiceInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Style\StyleInterface;

class RenamerService implements ServiceInterface
{
    protected $config;

    protected $io;

    public function __construct(object $config, StyleInterface $io)
    {
        $this->config = $config;
        $this->io = $io;
    }

    public function run()
    {
        // Group paths by directory name.
        $groups = $this->getPathGroups($this->config->root, $this->config->pattern);

        // Show suggestions by group.
        foreach ($groups as $group => $paths) {
            $suggestions = $this->createSuggestions($group, $paths);

            if (count($suggestions)) {
                $this->listSuggestions($group, $suggestions);

                if ($this->askConfirmation()) {
                    $this->renamePaths($group, $suggestions);
                }
            }
        }
    }

    public function getPathGroups(string $root, string $pattern)
    {
        $groups = [];

        foreach (glob("{$root}{$pattern}", GLOB_BRACE) as $path) {
            $groups[dirname($path)][] = basename($path);
        }

        return $groups;
    }

    protected function createSuggestions(string $dirname, array $basenames)
    {
        // Instantiate action classes.
        $actions = array_map(function ($action) {
            $class = "Renamer\\Action\\{$action->name}Action";
            return new $class($action->options);
        }, $this->config->actions);

        // Iterate through the basenames and create suggested names.
        $suggestions = array_map(function ($basename) use ($dirname, $actions) {
            // Apply actions to the basename.
            $pathinfo = pathinfo(implode(DIRECTORY_SEPARATOR, [$dirname, $basename]));
            $modified = array_reduce($actions, function ($carry, $action) {
                return $action->execute($carry);
            }, $pathinfo)['basename'];

            return ['original' => $basename, 'modified' => $modified];
        }, $basenames);

        // Return only the basenames that were modified.
        return array_filter($suggestions, function ($suggestion) {
            return $suggestion['original'] !== $suggestion['modified'];
        });
    }

    protected function listSuggestions(string $dirname, array $suggestions)
    {
        $this->io->writeln("<options=bold>Path: {$dirname}</>");
        $this->io->table(['Original', 'Modified'], $suggestions);
    }

    protected function askConfirmation()
    {
        return $this->io->confirm('Correct?');
    }

    protected function renamePaths(string $dirname, array $suggestions)
    {
        foreach ($suggestions as $suggestion) {
            rename(
                implode(DIRECTORY_SEPARATOR, [$dirname, $suggestion['original']]),
                implode(DIRECTORY_SEPARATOR, [$dirname, $suggestion['modified']])
            );
        }

        $count = count($suggestions);
        $this->io->writeln("<fg=green>Renamed {$count} files.</>\n");
    }
}
