<?php


namespace KLevesque\LCGS\Domain\Champion;


interface ChampionRepository
{

    public function getChampion(int $id) : Champion;

    public function getAll();

}