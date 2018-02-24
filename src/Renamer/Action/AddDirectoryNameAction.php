<?php
namespace Renamer\Action;

/**
 * Adds directory name to the filename.
 */
class AddDirectoryNameAction extends AbstractAction
{
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
        $directory = basename($pathinfo['dirname']);
        $separator = (string) $this->options['separator'];

        $pathinfo['filename'] = "{$directory}{$separator}{$pathinfo['filename']}";
        $pathinfo['basename'] = "{$pathinfo['filename']}.{$pathinfo['extension']}";

        return $pathinfo;
    }
}
