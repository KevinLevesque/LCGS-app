<?php
namespace KLevesque\LCGS\Services\Dto;

use DateTime;
use KLevesque\LCGS\Domain\Match\Participant;

class ParticipantMatchDto
{

    public MatchDto $match;
    public Participant $player;
    public ChampionDto $champion;
    public int $kills;
    public int $deaths;
    public int $assists;
    public int $totalDamageDealtToChampions;
    public string $role;
    public string $lane;

}


