<?php
namespace Renamer\Action;

class AddDirectoryNameAction implements ActionInterface
{
    public function execute(array $pathinfo)
    {
        $directory = basename($pathinfo['dirname']);

        $pathinfo['filename'] = "{$directory}{$pathinfo['filename']}";
        $pathinfo['basename'] = "{$pathinfo['filename']}.{$pathinfo['extension']}";

        return $pathinfo;
    }
}
