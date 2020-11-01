<?php

namespace KLevesque\LCGS\Services;

use AutoMapperPlus\AutoMapperInterface;
use KLevesque\LCGS\Domain\Champion\Champion;
use KLevesque\LCGS\Domain\Champion\ChampionRepository;
use KLevesque\LCGS\Domain\Champion\ChampionStatsCalculator;
use KLevesque\LCGS\Domain\Match\Match;
use KLevesque\LCGS\Domain\Match\MatchRepository;
use KLevesque\LCGS\Domain\Match\TeamColor;
use KLevesque\LCGS\Domain\Player\PlayerRepository;
use KLevesque\LCGS\Infrastructure\RiotApi\RiotApi;
use KLevesque\LCGS\Services\Dto\ChampionStatsDto;
use KLevesque\LCGS\Services\Dto\MatchDto;

class ChampionService
{

    /**
     * @var ChampionRepository
     */
    private ChampionRepository $championRepository;
    /**
     * @var ChampionStatsCalculator
     */
    private ChampionStatsCalculator $championStatsCalculator;
    /**
     * @var AutoMapperInterface
     */
    private AutoMapperInterface $mapper;
    /**
     * @var MatchRepository
     */
    private MatchRepository $matchRepository;

    public function __construct(ChampionRepository $championRepository, MatchRepository $matchRepository, ChampionStatsCalculator $championStatsCalculator, AutoMapperInterface $mapper)
    {
        $this->championRepository = $championRepository;
        $this->championStatsCalculator = $championStatsCalculator;
        $this->mapper = $mapper;
        $this->matchRepository = $matchRepository;
    }


    public function getChampionsStats(){
        $champions = $this->championRepository->getAll();

        $championsStats = [];
        /** @var Champion $champion */
        foreach ($champions as $champion){
            $championsStats[] = $champion->getChampionStats($this->championStatsCalculator);
        }

        return $this->mapper->mapMultiple($championsStats, ChampionStatsDto::class);
    }

    /**
     * @param string $championName
     * @return MatchDto[]
     */
    public function getMatches(string $championName) : array
    {
        $champion = $this->championRepository->getChampionByName($championName);

        $matches = $this->matchRepository->getMatchesWithChampion($champion);

        return $this->mapper->mapMultiple($matches, MatchDto::class);


    }

    /**
     * @param string $championName
     * @return ChampionStatsDto
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function getChampionStats(string $championName) : ChampionStatsDto
    {
        /** @var Champion $champion */
        $champion = $this->championRepository->getChampionByName($championName);

        $stats = $champion->getChampionStats($this->championStatsCalculator);

        return $this->mapper->map($stats, ChampionStatsDto::class);

    }


}
