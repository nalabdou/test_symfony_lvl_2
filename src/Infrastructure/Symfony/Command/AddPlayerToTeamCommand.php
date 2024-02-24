<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use App\Domain\Entity\Player;
use App\Domain\Entity\Team;
use App\Domain\Repository\PlayerRepository;
use App\Domain\Repository\TeamRepository;
use App\UseCase\AddPlayerToTeam\Request;
use App\UseCase\AddPlayerToTeam\UseCase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: self::COMMAND_NAME,
    description: 'Adds player to team.',
    hidden: false
)]
final class AddPlayerToTeamCommand extends Command
{
    public const COMMAND_NAME = 'app:team:add:player';

    public function __construct(
        private readonly UseCase $useCase,
        private readonly TeamRepository $teamRepository,
        private readonly PlayerRepository $playerRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var QuestionHelper */
        $helper = $this->getHelper('question');

        $playerQuestion = new ChoiceQuestion('Select the player', $this->playerRepository->findAll());
        $playerQuestion->setErrorMessage('Player %s is invalid.');

        $teamQuestion = new ChoiceQuestion('Select the team', $this->teamRepository->findAll());
        $teamQuestion->setErrorMessage('Team %s is invalid.');

        /** @var Player $player */
        $player = $helper->ask($input, $output, $playerQuestion);
        /** @var Team $team */
        $team = $helper->ask($input, $output, $teamQuestion);

        $io = new SymfonyStyle($input, $output);
        try {
            $response = $this->useCase->execute(new Request(
                team: $team,
                player: $player
            ));
        } catch (\Exception $ex) {
            $io->error($ex->getMessage());

            return Command::FAILURE;
        }

        $io->success(\sprintf('The player "%s" added to the team "%s"', $response->getPlayer(), $response->getTeam()));

        return self::SUCCESS;
    }
}
