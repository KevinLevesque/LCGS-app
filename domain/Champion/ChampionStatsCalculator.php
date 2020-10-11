<?php


namespace KLevesque\LCGS\Domain\Champion;


use KLevesque\LCGS\Domain\Match\Match;
use KLevesque\LCGS\Domain\Match\MatchRepository;

class ChampionStatsCalculator
{

    /**
     * @var MatchRepository
     */
    private MatchRepository $matchRepository;

    public function __construct(MatchRepository $matchRepository)
    {
        $this->matchRepository = $matchRepository;
    }


    public function calculateStats(Champion $champion) : ChampionStats{
        $matches = $this->matchRepository->getMatchsWithChampion($champion);

        $wins = 0;
        $losses = 0;
        $picks = 0;
        $bans = 0;

        /** @var Match $match */
        foreach ($matches as $match){
            if($match->championIsBanned($champion)){
                $bans++;
                continue; //Can't be picked or win if banned
            }

            $picks++;
            if($match->hasChampionWon($champion) ) {
                $wins++;
            }
            else {
                $losses++;
            }
        }

        return new ChampionStats($champion, $wins, $losses, $picks, $bans);
    }

}