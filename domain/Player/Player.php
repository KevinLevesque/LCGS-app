<?php
namespace KLevesque\LCGS\Domain\Player;

use KLevesque\LCGS\Domain\Match\Match;
use KLevesque\LCGS\Domain\Match\MatchRepository;
use Ramsey\Collection\Collection;

class Player
{

    private string $id;
    private string $username;

    public function __construct(string $id, string $username)
    {
        $this->id = $id;
        $this->username = $username;
    }








}