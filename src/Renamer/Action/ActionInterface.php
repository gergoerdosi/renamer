<?php
namespace Renamer\Action;

/**
 * Action interface.
 */
interface ActionInterface
{
    /**
     * Executes the action.
     *
     * @param array $pathinfo Array with information about the path.
     * @return string The modified pathinfo array.
     */
    public function execute(array $pathinfo);
}
