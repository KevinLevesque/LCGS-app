<?php


namespace KLevesque\LCGS\Domain\Player;


interface PlayerRepository
{

    public function save(Player $player);

    public function getPlayer(string $username);
    public function getAllPlayers();

}