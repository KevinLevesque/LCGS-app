<?php
namespace KLevesque\LCGS\Services\Dto;

use DateTime;

class ParticipantDto
{

    public string $id;
    public ?PlayerDto $player;
    public ChampionDto $champion;
    public int $kills;
    public int $deaths;
    public int $assists;
    public int $totalDamageDealtToChampions;
    public string $role;
    public string $lane;

}


