<?php

namespace KLevesque\LCGS\Domain\Champion;

class Champion
{

    private int $id;
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }


    public function getChampionStats(ChampionStatsCalculator $championStatsCalculator) : ChampionStats{
        return $championStatsCalculator->calculateStats($this);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }



}