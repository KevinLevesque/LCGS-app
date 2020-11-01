<?php

namespace KLevesque\LCGS\Services;

use AutoMapperPlus\AutoMapperInterface;
use KLevesque\LCGS\Domain\Match\MatchRepository;
use KLevesque\LCGS\Domain\Player\PlayerStatsCalculator;
use KLevesque\LCGS\Domain\Player\Player;
use KLevesque\LCGS\Domain\Player\PlayerRepository;
use KLevesque\LCGS\Infrastructure\RiotApi\RiotApi;
use KLevesque\LCGS\Services\Dto\MatchDto;
use KLevesque\LCGS\Services\Dto\PlayerDto;
use KLevesque\LCGS\Services\Dto\PlayerStatsDto;

class PlayerService
{
    private RiotApi $riotApi;
    /**
     * @var PlayerRepository
     */
    private PlayerRepository $playerRepository;
    /**
     * @var AutoMapperInterface
     */
    private AutoMapperInterface $mapper;
    /**
     * @var PlayerStatsCalculator
     */
    private PlayerStatsCalculator $playerStatsCalculator;
    /**
     * @var MatchRepository
     */
    private MatchRepository $matchRepository;


    public function __construct(RiotApi $riotApi, PlayerRepository $playerRepository, PlayerStatsCalculator $playerStatsCalculator, MatchRepository $matchRepository, AutoMapperInterface $mapper)
    {
        $this->riotApi = $riotApi;
        $this->playerRepository = $playerRepository;
        $this->mapper = $mapper;
        $this->playerStatsCalculator = $playerStatsCalculator;
        $this->matchRepository = $matchRepository;
    }


    public function addPlayer($username) : PlayerDto {
        $summoner = $this->riotApi->getSummoner($username);

        $player = new Player($summoner->id, $summoner->name);
        $this->playerRepository->save($player);
        return $this->mapper->map($player, PlayerDto::class);
    }

    /** @return PlayerDto[] */
    public function getAll() : array
    {
        $players = $this->playerRepository->getAllPlayers();
        return $this->mapper->mapMultiple($players, PlayerDto::class);
    }

    /** @return PlayerStatsDto[] */
    public function getAllStats() : array {
        $players = $this->playerRepository->getAllPlayers();

        $playersStats = [];

        /** @var Player $player */
        foreach ($players as $player){
            $playersStats[] = $player->getPlayerStats($this->playerStatsCalculator);
        }

        return $this->mapper->mapMultiple($playersStats, PlayerStatsDto::class);
    }

    /**
     * @param String $playerUsername
     * @return MatchDto[]
     */
    public function getMatches(String $playerUsername)
    {
        $player = $this->playerRepository->getPlayer($playerUsername);

        $matches = $this->matchRepository->getMatchesWithPlayer($player);

        return $this->mapper->mapMultiple($matches, MatchDto::class);
    }

    /**
     * @param string $playerUsername
     * @return PlayerStatsDto
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function getStats(string $playerUsername) : PlayerStatsDto
    {
        $player = $this->playerRepository->getPlayer($playerUsername);

        $stats = $player->getPlayerStats($this->playerStatsCalculator);

        return $this->mapper->map($stats, PlayerStatsDto::class);
    }
}
