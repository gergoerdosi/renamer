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
        $groups = $this->getPathGroups($this->config->root, $this->config->pattern);

        foreach ($groups as $group => $paths) {
            $suggestions = $this->createSuggestions($group, $paths);
            $this->listSuggestions($group, $suggestions);

            // if ($this->askConfirmation()) {
            //     $this->renamePaths($suggestions);
            // }
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
        $suggestions = array_map(function ($basename) use($dirname, $actions) {
            // Apply actions to the basename.
            $pathinfo = pathinfo(implode(DIRECTORY_SEPARATOR, [$dirname, $basename]));
            return array_reduce($actions, function ($carry, $action) {
                return $action->execute($carry);
            }, $pathinfo)['basename'];
        }, $basenames);

        // Return only the basenames that were modified.
        return array_filter(array_combine($basenames, $suggestions), function ($modified, $original) {
            return $modified !== $original;
        }, ARRAY_FILTER_USE_BOTH);
    }

    protected function listSuggestions(string $dirname, array $basenames)
    {
        $this->io->writeln("Files to be renamed in <options=bold>{$dirname}</>:");

        foreach ($basenames as $original => $modified) {
            $this->io->writeln("> {$original} => <fg=yellow>{$modified}</>");
        }
    }
}
