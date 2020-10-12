<?php


namespace KLevesque\LCGS\Domain\Player;


use KLevesque\LCGS\Domain\Match\Match;
use KLevesque\LCGS\Domain\Match\MatchRepository;
use KLevesque\LCGS\Domain\Player\Player;
use KLevesque\LCGS\Domain\Player\PlayerStats;

class PlayerStatsCalculator
{

    /**
     * @var MatchRepository
     */
    private MatchRepository $matchRepository;

    public function __construct(MatchRepository $matchRepository)
    {
        $this->matchRepository = $matchRepository;
    }


    public function calculateStats(Player $player) : PlayerStats{
        $matches = $this->matchRepository->getMatchesWithPlayer($player);

        $wins = 0;
        $games = 0;

        /** @var Match $match */
        foreach ($matches as $match){
            $games++;
            if($match->hasPlayerWon($player)){
                $wins++;
            }
        }

        return new PlayerStats($player, $games, $wins);
    }

}