<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Entity\Player;
use App\Domain\Entity\Team;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Repository\TeamRepository as RepositoryTeamRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class TeamRepository extends ServiceEntityRepository implements RepositoryTeamRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly PlayerRepository $playerRepository
    ) {
        parent::__construct($registry, Team::class);
    }

    public function create(Team $team, ?bool $flush = false): void
    {
        $this->_em->persist($team);

        if ($flush) {
            $this->_em->flush();
        }
    }
    /**
     * @return Team[]
     */
    public function findAll(): array
    {
        return $this->findBy(criteria: [], orderBy: ['name' => Criteria::ASC]);
    }

    /**
     * @return Team[]
     */
    public function findToDisplay(): array
    {
        return $this->createQueryBuilder('t')
            ->select('t.id, t.name')
            ->orderBy('t.name', Criteria::ASC)
            ->getQuery()
            ->getArrayResult();
    }

    public function addPlayer(Team $team, Player $player, ?bool $flush = false): void
    {
        $team->addPlayer($player);
        $player->addTeam($team);
        $this->_em->persist($team);

        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param Team[] $teams
     * @return Team[]
     */
    public function findAllWithout(array $teams): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.name', Criteria::ASC)
            ->andWhere('t.id NOT IN(:teams)')
            ->setParameter('teams', \array_map(static fn (Team $team) => $team->getId(), $teams))
            ->getQuery()
            ->getResult();
    }
}
