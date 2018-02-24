<?php
namespace Renamer\Tests\Action;

use PHPUnit\Framework\TestCase;
use Renamer\Action\AddNumberAction;

class AddNumberActionTest extends TestCase
{
    public function testDefaultsToNoSeparator()
    {
        $path = '/main/sub/name.test';

        $action = new AddNumberAction();
        $modified = $action->execute(pathinfo($path));

        $this->assertEquals('name0001', $modified['filename']);
        $this->assertEquals('name0001.test', $modified['basename']);
    }

    public function testUsesSeparatorIfProvided()
    {
        $path = '/main/sub/name.test';

        $action = new AddNumberAction(['separator' => '_']);
        $modified = $action->execute(pathinfo($path));

        $this->assertEquals('name_0001', $modified['filename']);
        $this->assertEquals('name_0001.test', $modified['basename']);
    }

    public function testAddsNumberToName()
    {
        $path = '/main/sub/name.test';

        $action = new AddNumberAction();
        $modified = $action->execute(pathinfo($path));

        $this->assertEquals('name0001', $modified['filename']);
        $this->assertEquals('name0001.test', $modified['basename']);
    }

    public function testIncreasesNumberWithMultiplePaths()
    {
        $paths = [
            '/main/sub/first.test',
            '/main/sub/second.test'
        ];

        $action = new AddNumberAction();
        $first = $action->execute(pathinfo($paths[0]));
        $second = $action->execute(pathinfo($paths[1]));

        $this->assertEquals('first0001', $first['filename']);
        $this->assertEquals('first0001.test', $first['basename']);

        $this->assertEquals('second0002', $second['filename']);
        $this->assertEquals('second0002.test', $second['basename']);
    }
}
