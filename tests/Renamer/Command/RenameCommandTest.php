<?php
namespace Renamer\Tests\Command;

use PHPUnit\Framework\TestCase;
use Renamer\Command\RenameCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;

class RenameCommandTest extends TestCase
{
    public function testConfigArgumentIsRequired()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "config")');

        $arguments = [];
        $this->executeCommand($arguments);
    }

    /**
     * This helper method abstracts the boilerplate code needed to test the
     * execution of a command.
     *
     * @param array $arguments All the arguments passed when executing the command.
     */
    protected function executeCommand(array $arguments = [])
    {
        $application = new Application();
        $application->add(new RenameCommand());

        $command = $application->find('renamer:rename');
        $tester = new CommandTester($command);
        $tester->execute($arguments);
    }
}
