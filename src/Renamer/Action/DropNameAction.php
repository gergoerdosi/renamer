<?php
namespace Renamer\Action;

/**
 * Drops the filename.
 */
class DropNameAction extends AbstractAction
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
