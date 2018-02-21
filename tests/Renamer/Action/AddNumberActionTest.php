<?php
namespace Renamer\Tests\Action;

use PHPUnit\Framework\TestCase;
use Renamer\Action\AddNumberAction;

class AddNumberActionTest extends TestCase
{
    public function testAddsNumberToName()
    {
        $path = '/main/sub/name.test';

        $action = new AddNumberAction();
        $modified = $action->execute(pathinfo($path));

        $this->assertEquals('name_0001', $modified['filename']);
        $this->assertEquals('name_0001.test', $modified['basename']);
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

        $this->assertEquals('first_0001', $first['filename']);
        $this->assertEquals('first_0001.test', $first['basename']);

        $this->assertEquals('second_0002', $second['filename']);
        $this->assertEquals('second_0002.test', $second['basename']);
    }
}
