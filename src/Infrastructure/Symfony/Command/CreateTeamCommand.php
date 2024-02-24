<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use App\Domain\Exception\ValidationException;
use App\UseCase\CreateTeam\Request;
use App\UseCase\CreateTeam\UseCase;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: self::COMMAND_NAME,
    description: 'Creates a new team.',
    hidden: false
)]
final class CreateTeamCommand extends Command
{
    final public const COMMAND_NAME = 'app:team:create';
    final public const ARGUMENT_TEAM_NAME = 'name';

    public function __construct(private readonly UseCase $useCase)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(self::ARGUMENT_TEAM_NAME, InputArgument::REQUIRED, 'The name of the team.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $response = $this->useCase->execute(new Request($input->getArgument(self::ARGUMENT_TEAM_NAME)));
        } catch (ValidationException|UniqueConstraintViolationException $validation) {
            $io->error($validation->getMessage());

            return self::FAILURE;
        }
        $io->success(\sprintf('Team has been created. Id is : %s', $response->getId()));

        return self::SUCCESS;
    }
}
