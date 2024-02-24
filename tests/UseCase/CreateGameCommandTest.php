<?php

declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Infrastructure\Symfony\Command\CreateGameCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @depends App\Tests\UseCase\CreateTeamTest::testExecute
 * @depends App\Tests\UseCase\CreatePlayerTest::testExecute
 */
class CreateGameCommandTest extends KernelTestCase
{
    /**
     * @dataProvider gamesProvider
     */
    public function testExecute(array $inputs): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find(CreateGameCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $commandTester->setInputs($inputs);

        $r = $commandTester->execute(['command' => $command->getName()]);
        $this->assertSame(Command::SUCCESS, $r);
    }

    public function testNotWorkingWithMoreThan255Characters(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find(CreateGameCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['m46vsiOVh8f0d91SRtHxLd6q6L7l3skghubbLohDhdoUiUUMD1tOU8ijuqPV1SDcr4IuWZ6s7zE2nkSZb8n0SBj9uOodybXeHuqVaMDXCIIjcder3piE9ZrxVNUktEgh7fqbPHQhwBYsjjqg4v2vEXVQWUSpu4aMtxrXuqrRlKvsGTc4IqTs6MomFeqOByJB0NTYD3v1kMiR6xUem4BllRAYw67tnWCA2tFCAy3ifOpvI9Rnfvyn8MdBVtVVmyNR', \random_int(0, 18), \random_int(0, 17)]);

        $r = $commandTester->execute(['command' => $command->getName()]);
        $this->assertSame(Command::FAILURE, $r);
    }

    public function gamesProvider(): \Generator
    {
        yield [['Champions League Semi-Final Leg 1', \random_int(0, 18), \random_int(0, 17)]];
        yield [['Champions League Semi-Final Leg 2', \random_int(0, 18), \random_int(0, 17)]];
        yield [['Europa League Semi-Final Leg 1', \random_int(0, 18), \random_int(0, 17)]];
        yield [['Europa League Semi-Final Leg 2', \random_int(0, 18), \random_int(0, 17)]];
        yield [['FA Cup Semi-Final 1', \random_int(0, 18), \random_int(0, 17)]];
        yield [['FA Cup Semi-Final 2', \random_int(0, 18), \random_int(0, 17)]];
    }
}
