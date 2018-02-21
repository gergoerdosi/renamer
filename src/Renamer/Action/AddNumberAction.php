<?php
namespace Renamer\Action;

/**
 * Adds incremented number to the filename.
 */
class AddNumberAction implements ActionInterface
{
    /**
     * @var int The current count.
     */
    protected $counter = 0;

    /**
     * {@inheritdoc}
     */
    public function execute(array $pathinfo)
    {
        $counter = str_pad(++$this->counter, 4, '0', STR_PAD_LEFT);
        $pathinfo['filename'] = "{$pathinfo['filename']}_{$counter}";
        $pathinfo['basename'] = "{$pathinfo['filename']}.{$pathinfo['extension']}";

        return $pathinfo;
    }
}
