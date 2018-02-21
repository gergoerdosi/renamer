<?php
namespace Renamer\Tests\Action;

use PHPUnit\Framework\TestCase;
use Renamer\Action\DropNameAction;

class DropNameActionTest extends TestCase
{
    public function testDropsTextFromName()
    {
        $path = '/main/sub/name.test';

        $action = new DropNameAction();
        $modified = $action->execute(pathinfo($path));

        $this->assertEquals('', $modified['filename']);
        $this->assertEquals('.test', $modified['basename']);
    }
}
