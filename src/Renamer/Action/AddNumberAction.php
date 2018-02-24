<?php
namespace Renamer\Action;

/**
 * Adds incremented number to the filename.
 */
class AddNumberAction extends AbstractAction
{
    /**
     * @var int The current count.
     */
    protected $counter = 0;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $options = [])
    {
        $default = [
            'separator' => ''
        ];

        return parent::__construct(array_merge($default, $options));
    }

    /**
     * {@inheritdoc}
     */
    public function execute(array $pathinfo)
    {
        $counter = str_pad(++$this->counter, 4, '0', STR_PAD_LEFT);
        $separator = (string) $this->options['separator'];

        $pathinfo['filename'] = "{$pathinfo['filename']}{$separator}{$counter}";
        $pathinfo['basename'] = "{$pathinfo['filename']}.{$pathinfo['extension']}";

        return $pathinfo;
    }
}
