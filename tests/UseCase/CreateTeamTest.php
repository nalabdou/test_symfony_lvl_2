<?php

declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Infrastructure\Symfony\Command\CreateTeamCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CreateTeamTest extends KernelTestCase
{
    /**
     * @dataProvider teamsProvider
     */
    public function testExecute(string $teamName): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find(CreateTeamCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $r = $commandTester->execute([
            CreateTeamCommand::ARGUMENT_TEAM_NAME => $teamName,
        ]);
        $this->assertSame(Command::SUCCESS, $r);
    }

    public function testNotWorkingWithMoreThan255Characters(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find(CreateTeamCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $r = $commandTester->execute([
            CreateTeamCommand::ARGUMENT_TEAM_NAME => 'm46vsiOVh8f0d91SRtHxLd6q6L7l3skghubbLohDhdoUiUUMD1tOU8ijuqPV1SDcr4IuWZ6s7zE2nkSZb8n0SBj9uOodybXeHuqVaMDXCIIjcder3piE9ZrxVNUktEgh7fqbPHQhwBYsjjqg4v2vEXVQWUSpu4aMtxrXuqrRlKvsGTc4IqTs6MomFeqOByJB0NTYD3v1kMiR6xUem4BllRAYw67tnWCA2tFCAy3ifOpvI9Rnfvyn8MdBVtVVmyNR',
        ]);
        $this->assertSame(Command::FAILURE, $r);
    }

    /**
     * @dataProvider teamsProvider
     */
    public function testNotWorkingWithDuplicatedData(string $teamName): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find(CreateTeamCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $r = $commandTester->execute([
            CreateTeamCommand::ARGUMENT_TEAM_NAME => $teamName,
        ]);
        $this->assertSame(Command::FAILURE, $r);
    }

    public function teamsProvider(): \Generator
    {
        yield ['RC Strasbourg'];
        yield ['Paris Saint-Germain'];
        yield ['Olympique de Marseille'];
        yield ['Lille OSC'];
        yield ['AS Monaco'];
        yield ['Olympique Lyonnais'];
        yield ['Stade Rennais'];
        yield ['OGC Nice'];
        yield ['FC Nantes'];
        yield ['Montpellier HSC'];
        yield ['RC Lens'];
        yield ['Stade Brestois'];
        yield ['AS Saint-Étienne'];
        yield ['Angers SCO'];
        yield ['FC Metz'];
        yield ['FC Girondins de Bordeaux'];
        yield ['Stade de Reims'];
        yield ['Nîmes Olympique'];
        yield ['FC Lorient'];
    }
}
