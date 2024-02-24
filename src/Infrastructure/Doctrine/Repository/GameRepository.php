<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Entity\Game;
use App\Domain\Entity\Team;
use App\Domain\Repository\GameRepository as RepositoryGameRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository implements RepositoryGameRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function create(Game $game, ?bool $flush = false): void
    {
        $this->_em->persist($game);

        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findAll(): array
    {
        return $this->findBy(criteria: [], orderBy: ['name' => Criteria::ASC]);
    }

    public function findToDisplay(?Team $team = null): array
    {
        $qb = $this->createQueryBuilder('g')
            ->select('g.id, g.name, gh.name as home, ga.name as away')
            ->join('g.homeTeam', 'gh')
            ->join('g.awayTeam', 'ga')
            ->orderBy('g.name', Criteria::ASC);

        if (!\is_null($team)) {
            $qb
                ->orWhere('gh = :team')
                ->orWhere('ga = :team')
                ->setParameter('team', $team);
        }

        return $qb->getQuery()->getResult();
    }
}
