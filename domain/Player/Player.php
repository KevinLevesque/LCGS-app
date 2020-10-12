<?php
namespace KLevesque\LCGS\Domain\Player;

class Player
{

    private string $id;
    private string $username;

    public function __construct(string $id, string $username)
    {
        $this->id = $id;
        $this->username = $username;
    }

    public function getPlayerStats(PlayerStatsCalculator $calculator) : PlayerStats{
        return $calculator->calculateStats($this);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }










}