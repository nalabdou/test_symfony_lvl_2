<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Entity\Team;
use App\Domain\Repository\TeamRepository as RepositoryTeamRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class TeamRepository extends ServiceEntityRepository implements RepositoryTeamRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    public function create(Team $team, ?bool $flush = false): void
    {
        $this->_em->persist($team);

        if ($flush) {
            $this->_em->flush();
        }
    }
}