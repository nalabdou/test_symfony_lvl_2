<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use App\Domain\Entity\Team;
use App\Domain\Exception\ValidationException;
use App\Domain\Repository\TeamRepository;
use App\UseCase\CreateGame\Request;
use App\UseCase\CreateGame\UseCase;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: self::COMMAND_NAME,
    description: 'Creates a new game.',
    hidden: false
)]
final class CreateGameCommand extends Command
{
    final public const COMMAND_NAME = 'app:game:create';

    public function __construct(
        private readonly UseCase $useCase,
        private readonly TeamRepository $teamRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var QuestionHelper */
        $helper = $this->getHelper('question');

        $nameQuestion = new Question("<fg=green>Type the game's name :\n</>");
        $name = (string) $helper->ask($input, $output, $nameQuestion);

        $homeTeamQuestion = new ChoiceQuestion('<fg=green>Select the home team :</>', $this->teamRepository->findAll());
        $homeTeamQuestion->setErrorMessage('Team %s is invalid.');

        /** @var Team $homeTeam */
        $homeTeam = $helper->ask($input, $output, $homeTeamQuestion);

        $awayTeamQuestion = new ChoiceQuestion('<fg=green>Select the away team :</>', $this->teamRepository->findAllWithout([$homeTeam]));
        $awayTeamQuestion->setErrorMessage('Team %s is invalid.');

        /** @var Team $awayTeam */
        $awayTeam = $helper->ask($input, $output, $awayTeamQuestion);
        $io = new SymfonyStyle($input, $output);
        try {
            $response = $this->useCase->execute(new Request($name, $homeTeam, $awayTeam));
        } catch (ValidationException|UniqueConstraintViolationException $validation) {
            $io->error($validation->getMessage());

            return Command::FAILURE;
        }

        $io->success(\sprintf('Game has been created. Between "%s" and "%s" Id is : %s', $homeTeam, $awayTeam, $response->getId()));

        return self::SUCCESS;
    }
}
