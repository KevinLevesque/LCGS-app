<?php


namespace KLevesque\LCGS\Domain\Champion;


use KLevesque\LCGS\Domain\Champion\Champion;

class ChampionStats
{

    private Champion $champion;
    private int $wins;
    private int $picks;
    private int $bans;
    private int $losses;


    public function __construct(Champion $champion, int $wins, int $losses, int $picks, int $bans)
    {
        $this->champion = $champion;
        $this->wins = $wins;
        $this->picks = $picks;
        $this->bans = $bans;
        $this->losses = $losses;
    }

}