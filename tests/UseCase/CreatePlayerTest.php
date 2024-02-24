<?php

namespace App\Tests\UseCase;

use App\Infrastructure\Symfony\Command\CreatePlayerCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CreatePlayerTest extends KernelTestCase
{
    /**
     * @dataProvider playersProvider
     */
    public function testExecute(string $playerName): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find(CreatePlayerCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $r = $commandTester->execute([
            CreatePlayerCommand::ARGUMENT_PLAYER_NAME => $playerName,
        ]);
        $this->assertSame(Command::SUCCESS, $r);
    }

    public function testNotWorkingWithMoreThan255Characters(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find(CreatePlayerCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $r = $commandTester->execute([
            CreatePlayerCommand::ARGUMENT_PLAYER_NAME => 'm46vsiOVh8f0d91SRtHxLd6q6L7l3skghubbLohDhdoUiUUMD1tOU8ijuqPV1SDcr4IuWZ6s7zE2nkSZb8n0SBj9uOodybXeHuqVaMDXCIIjcder3piE9ZrxVNUktEgh7fqbPHQhwBYsjjqg4v2vEXVQWUSpu4aMtxrXuqrRlKvsGTc4IqTs6MomFeqOByJB0NTYD3v1kMiR6xUem4BllRAYw67tnWCA2tFCAy3ifOpvI9Rnfvyn8MdBVtVVmyNR',
        ]);
        $this->assertSame(Command::FAILURE, $r);
    }

    public function playersProvider(): \Generator
    {
        yield ['Kylian Mbappé'];
        yield ['Neymar Jr.'];
        yield ['Lionel Messi'];
        yield ['Andres Iniesta'];
        yield ['Cristiano Ronaldo'];
        yield ['Luka Modrić'];
        yield ['Mohamed Salah'];
        yield ['Robert Lewandowski'];
        yield ['Sergio Ramos'];
        yield ['Kevin De Bruyne'];
        yield ['Virgil van Dijk'];
        yield ['Harry Kane'];
        yield ['Erling Haaland'];
        yield ['Bruno Fernandes'];
        yield ['Joshua Kimmich'];
        yield ['Karim Benzema'];
        yield ['Romelu Lukaku'];
        yield ['Paul Pogba'];
        yield ['Thomas Müller'];
        yield ['Jadon Sancho'];
    }
}
