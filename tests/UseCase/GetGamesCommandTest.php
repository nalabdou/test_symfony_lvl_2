<?php

declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Infrastructure\Symfony\Command\GetGamesCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class GetGamesCommandTest extends KernelTestCase
{
    public function testExecute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find(GetGamesCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $r = $commandTester->execute([]);
        $this->assertSame(Command::SUCCESS, $r);
    }

    /**
     * @dataProvider randomInput
     */
    public function testExecuteWithTeam(int $input): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find(GetGamesCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $commandTester->setInputs([$input]);
        $r = $commandTester->execute([
            '-t' => true,
            'command' => $command->getName(),
        ]);

        $this->assertSame(Command::SUCCESS, $r);
    }

    public function randomInput(): \Generator
    {
        for ($i = 0; $i < 18; ++$i) {
            yield [\random_int(0, 18)];
        }
    }
}
