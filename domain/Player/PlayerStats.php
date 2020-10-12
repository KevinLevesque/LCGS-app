<?php


namespace KLevesque\LCGS\Domain\Player;


class PlayerStats
{

    private Player $player;

    private int $games = 0;
    private int $wins = 0;

    /**
     * PlayerStats constructor.
     * @param Player $player
     * @param int $games
     * @param int $wins
     */
    public function __construct(Player $player, int $games, int $wins)
    {
        $this->player = $player;
        $this->games = $games;
        $this->wins = $wins;
    }


}