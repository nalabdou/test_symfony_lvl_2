<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use App\Domain\Entity\Team;
use App\Domain\Repository\TeamRepository;
use App\UseCase\GetGames\Request;
use App\UseCase\GetGames\UseCase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

#[AsCommand(
    name: self::COMMAND_NAME,
    description: 'Display games.',
    hidden: false
)]
final class GetGamesCommand extends Command
{
    public const COMMAND_NAME = 'app:game:list';

    public function __construct(
        private readonly UseCase $useCase,
        private readonly TeamRepository $teamRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption(
                'choose-team',
                't',
                InputOption::VALUE_NONE,
                'Select a team to view its upcoming or past games.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $chooseTeam = (bool) $input->getOption('choose-team');
        $team = null;

        if ($chooseTeam) {
            /** @var QuestionHelper */
            $helper = $this->getHelper('question');
            $teamQuestion = new ChoiceQuestion('<fg=green>Select team :</>', $this->teamRepository->findAll());
            $teamQuestion->setErrorMessage('Team %s is invalid.');

            /** @var Team $team */
            $team = $helper->ask($input, $output, $teamQuestion);
        }

        $response = $this->useCase->execute(new Request($team));

        $table = new Table($output);

        $table
            ->setHeaders(['Id', 'Name', 'Home', 'Away'])
            ->setRows($response->getGames());
        $table->render();

        return self::SUCCESS;
    }
}
