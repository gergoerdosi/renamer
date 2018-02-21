<?php
namespace Renamer\Action;

/**
 * Adds directory name to the filename.
 */
class AddDirectoryNameAction implements ActionInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute(array $pathinfo)
    {
        $directory = basename($pathinfo['dirname']);

        $pathinfo['filename'] = "{$directory}{$pathinfo['filename']}";
        $pathinfo['basename'] = "{$pathinfo['filename']}.{$pathinfo['extension']}";

        return $pathinfo;
    }
}
