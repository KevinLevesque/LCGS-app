<?php


namespace KLevesque\LCGS\Infrastructure\persistence\doctrine;


use Doctrine\ORM\EntityManagerInterface;
use KLevesque\LCGS\Domain\Champion\Champion;
use KLevesque\LCGS\Domain\Champion\ChampionRepository;
use KLevesque\LCGS\Infrastructure\RiotApi\RiotApi;

class DoctrineChampionRepository implements ChampionRepository
{


    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;
    /**
     * @var RiotApi
     */
    private RiotApi $riotApi;

    public function __construct(EntityManagerInterface $em, RiotApi $leagueAPI)
    {
        $this->em = $em;
        $this->riotApi = $leagueAPI;
    }

    public function getChampion(int $id): Champion
    {
        $champion = $this->em->getRepository(Champion::class)->find($id);

        if (!$champion) {
            $this->syncChampionWithApi($id);
            $champion = $this->em->getRepository(Champion::class)->find($id);
        }

        return $champion;
    }

    public function getChampionByName(string $name): Champion
    {
        return $this->em->getRepository(Champion::class)->findOneBy(['name' => $name]);
    }

    private function syncChampionWithApi(int $id)
    {
        $apiChampion = $this->riotApi->getChampion($id);
        $this->em->persist(new Champion($apiChampion->key, $apiChampion->name));


    }

    public function getAll()
    {
        return $this->em->getRepository(Champion::class)->findAll();
    }
}