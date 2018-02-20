<?php
namespace Renamer\Action;

use Renamer\Action\ActionInterface;

class AddNumberAction implements ActionInterface
{
    protected $counter = 0;

    public function execute(array $pathinfo)
    {
        $counter = str_pad(++$this->counter, 4, '0', STR_PAD_LEFT);
        $pathinfo['filename'] = "{$pathinfo['filename']}_{$counter}";
        $pathinfo['basename'] = "{$pathinfo['filename']}.{$pathinfo['extension']}";

        return $pathinfo;
    }
}
