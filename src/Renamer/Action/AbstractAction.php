<?php
namespace Renamer\Action;

/**
 * Abstract action class.
 */
abstract class AbstractAction implements ActionInterface
{
    /**
     * @var int Options.
     */
    protected $options;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }
}
