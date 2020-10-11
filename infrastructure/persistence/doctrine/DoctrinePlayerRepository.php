<?php


namespace KLevesque\LCGS\Infrastructure\persistence\doctrine;


use Doctrine\ORM\EntityManagerInterface;
use KLevesque\LCGS\Domain\Champion\Champion;
use KLevesque\LCGS\Domain\Champion\ChampionRepository;
use KLevesque\LCGS\Domain\Player\Player;
use KLevesque\LCGS\Domain\Player\PlayerRepository;
use KLevesque\LCGS\Infrastructure\RiotApi\RiotApi;
use RiotAPI\LeagueAPI\LeagueAPI;

class DoctrinePlayerRepository implements PlayerRepository
{


    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getPlayer(string $username): Player
    {
        return $this->em->getRepository(Player::class)->findOneBy(['username' => $username]);
    }


    public function save(Player $player)
    {
        $this->em->persist($player);
        $this->em->flush();
    }


    /** @return Player[] */
    public function getAllPlayers() : array
    {
        return $this->em->getRepository(Player::class)->findAll();
    }
}