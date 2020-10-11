<?php

namespace KLevesque\LCGS\Services;

use AutoMapperPlus\AutoMapperInterface;
use KLevesque\LCGS\Domain\Player\Player;
use KLevesque\LCGS\Domain\Player\PlayerRepository;
use KLevesque\LCGS\Infrastructure\RiotApi\RiotApi;
use KLevesque\LCGS\Services\Dto\PlayerDto;

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


    public function __construct(RiotApi $riotApi, PlayerRepository $playerRepository, AutoMapperInterface $mapper)
    {
        $this->riotApi = $riotApi;
        $this->playerRepository = $playerRepository;
        $this->mapper = $mapper;
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
}
