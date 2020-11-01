<?php


namespace KLevesque\LCGS\Infrastructure\persistence\doctrine;


use Doctrine\ORM\EntityManagerInterface;
use KLevesque\LCGS\Domain\Champion\Champion;
use KLevesque\LCGS\Domain\Champion\ChampionRepository;
use KLevesque\LCGS\Domain\Match\Match;
use KLevesque\LCGS\Domain\Match\MatchRepository;
use KLevesque\LCGS\Domain\Match\Team;
use KLevesque\LCGS\Domain\Player\Player;
use KLevesque\LCGS\Infrastructure\RiotApi\RiotApi;
use RiotAPI\LeagueAPI\LeagueAPI;

class DoctrineMatchRepository implements MatchRepository
{


    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getMatch(int $id): Match
    {
        return $this->em->getRepository(Match::class)->find($id);
    }


    public function save(Match $match)
    {
        $this->em->persist($match);
        $this->em->flush();
    }


    public function getAll()
    {
        return $this->em->getRepository(Match::class)->findAll();
    }

    public function getMatchesWithPlayer(Player $player)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('match')
            ->from(Match::class, 'match')
            ->innerJoin('match.teams', 'team')
            ->innerJoin('team.participants', 'participant')
            ->innerJoin('participant.player', 'player');

        $qb->andWhere($qb->expr()->eq('player.id', ':id'))
            ->setParameter('id', $player->getId());

        return $qb->getQuery()->getResult();
    }

    public function getMatchesWithChampion(Champion $champion)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('match')
            ->from(Match::class, 'match')
            ->innerJoin('match.teams', 'team')
            ->innerJoin('team.championsBans', 'ban')
            ->innerJoin('team.participants', 'participant')
            ->innerJoin('participant.champion', 'pick');

        $qb->andWhere($qb->expr()->eq('ban.id', ':id'))
            ->orWhere($qb->expr()->eq('pick.id', ':id'))
            ->setParameter('id', $champion->getId());

        return $qb->getQuery()->getResult();

    }


    public function getMatchesAmount() : int
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('COUNT(match.id)')->from(Match::class, 'match');

        return $qb->getQuery()->getSingleScalarResult();
    }
}