<?php
namespace KLevesque\LCGS\Domain\Match;

use KLevesque\LCGS\Domain\Champion\Champion;
use KLevesque\LCGS\Domain\Player\Player;

class Participant
{
    private string $id;
    private ?Player $player;
    private Champion $champion;
    private int $kills;
    private int $deaths;
    private int $assists;
    private int $totalDamageDealtToChampions;
    private string $role;
    private string $lane;

    /**
     * Participant constructor.
     * @param Player $player
     * @param Champion $champion
     * @param int $kills
     * @param int $deaths
     * @param int $assists
     * @param int $totalDamageDealtToChampions
     * @param string $role
     * @param string $lane
     */
    public function __construct(?Player $player, Champion $champion, int $kills, int $deaths, int $assists, int $totalDamageDealtToChampions, string $role, string $lane)
    {
        $this->id = uniqid();
        $this->player = $player;
        $this->champion = $champion;
        $this->kills = $kills;
        $this->deaths = $deaths;
        $this->assists = $assists;
        $this->totalDamageDealtToChampions = $totalDamageDealtToChampions;
        $this->role = $role;
        $this->lane = $lane;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Player|null
     */
    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    /**
     * @return Champion
     */
    public function getChampion(): Champion
    {
        return $this->champion;
    }

    /**
     * @return int
     */
    public function getKills(): int
    {
        return $this->kills;
    }

    /**
     * @return int
     */
    public function getDeaths(): int
    {
        return $this->deaths;
    }

    /**
     * @return int
     */
    public function getAssists(): int
    {
        return $this->assists;
    }

    /**
     * @return int
     */
    public function getTotalDamageDealtToChampions(): int
    {
        return $this->totalDamageDealtToChampions;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getLane(): string
    {
        return $this->lane;
    }

    public function setPlayer(Player $player){
        $this->player = $player;
    }





}