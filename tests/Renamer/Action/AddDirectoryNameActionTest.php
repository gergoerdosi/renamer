<?php
namespace Renamer\Tests\Action;

use PHPUnit\Framework\TestCase;
use Renamer\Action\AddDirectoryNameAction;

class AddDirectoryNameActionTest extends TestCase
{
  public function testDefaultsToNoSeparator()
    {
        $path = '/main/sub/name.test';

        $action = new AddDirectoryNameAction();
        $modified = $action->execute(pathinfo($path));

        $this->assertEquals('subname', $modified['filename']);
        $this->assertEquals('subname.test', $modified['basename']);
    }

    public function testUsesSeparatorIfProvided()
    {
        $path = '/main/sub/name.test';

        $action = new AddDirectoryNameAction(['separator' => '_']);
        $modified = $action->execute(pathinfo($path));

        $this->assertEquals('sub_name', $modified['filename']);
        $this->assertEquals('sub_name.test', $modified['basename']);
    }

    public function testAddDirectoryNameToName()
    {
        $path = '/main/sub/name.test';

        $action = new AddDirectoryNameAction();
        $modified = $action->execute(pathinfo($path));

        $this->assertEquals('subname', $modified['filename']);
        $this->assertEquals('subname.test', $modified['basename']);
    }
}
