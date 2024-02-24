<?php

declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Infrastructure\Symfony\Command\AddPlayerToTeamCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @depends App\Tests\UseCase\CreateTeamTest::testExecute
 * @depends App\Tests\UseCase\CreatePlayerTest::testExecute
 */
class AddPlayerToTeamTest extends KernelTestCase
{
    /**
     * @dataProvider randomInputs
     */
    public function testExecute(array $inputs): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find(AddPlayerToTeamCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);

        $commandTester->setInputs($inputs);
        $r = $commandTester->execute(['command' => $command->getName()]);
        $this->assertSame(Command::SUCCESS, $r);
    }

    public function randomInputs(): \Generator
    {
        for ($i = 0; $i < 18; ++$i) {
            yield [[\random_int(0, 19), \random_int(0, 18)]];
        }
    }
}
