<?php
namespace Renamer\Action;

/**
 * Drops the filename.
 */
class DropNameAction implements ActionInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute(array $pathinfo)
    {
        $pathinfo['filename'] = '';
        $pathinfo['basename'] = "{$pathinfo['filename']}.{$pathinfo['extension']}";

        return $pathinfo;
    }
}
