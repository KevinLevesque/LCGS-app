<?php


namespace KLevesque\LCGS\Domain\Match;


use KLevesque\LCGS\Domain\Champion\Champion;
use KLevesque\LCGS\Domain\Player\Player;

interface MatchRepository
{

    public function getMatch(int $matchId) : Match;
    public function save(Match $match);
    public function getMatchesWithPlayer(Player $player);
    public function getAll();
    public function getMatchsWithChampion(Champion $champion);

}