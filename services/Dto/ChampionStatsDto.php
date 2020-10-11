<?php
namespace KLevesque\LCGS\Services\Dto;


class ChampionStatsDto
{

    public ChampionDto $champion;
    public int $wins;
    public int $losses;
    public int $picks;
    public int $bans;

}