<?php
namespace Renamer\Action;

class DropNameAction implements ActionInterface
{
    public function execute(array $pathinfo)
    {
        $pathinfo['filename'] = '';
        $pathinfo['basename'] = "{$pathinfo['filename']}.{$pathinfo['extension']}";

        return $pathinfo;
    }
}
