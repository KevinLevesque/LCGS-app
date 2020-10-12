<?php

namespace KLevesque\LCGS\Domain\Match;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use KLevesque\LCGS\Domain\Champion\Champion;
use KLevesque\LCGS\Domain\Player\Player;

class Match
{

    private int $id;


    private Collection $teams;
    private DateTime $date;


    private TeamColor $winnerTeamColor;

    public function __construct(int $id, DateTime $dateTime, TeamColor $winnerTeamColor)
    {
        $this->id = $id;

        $this->teams = new ArrayCollection();
        $this->teams->set(TeamColor::BLUE, new Team(TeamColor::blue()));
        $this->teams->set(TeamColor::RED, new Team(TeamColor::red()));


        $this->winnerTeamColor = $winnerTeamColor;
        $this->date = $dateTime;
    }


    public function addTeamParticipant(TeamColor $teamColor, ?Player $player, Champion $champion, int $kills, int $deaths, int $assists, $totalDamageDealtToChampions, $role, $lane)
    {
        $participant = new Participant($player, $champion, $kills, $deaths, $assists, $totalDamageDealtToChampions, $role, $lane);
        $this->teams->get($teamColor->value)->addParticipant($participant);
    }


    public function addTeamChampionBan(TeamColor $teamColor, Champion $champion)
    {
        $this->teams->get($teamColor->value)->addChampionBan($champion);
    }


    public function setPlayer(string $participantId, Player $player): bool
    {
        /** @var Team $team */
        foreach ($this->teams as $team) {
            /** @var Participant $participant */
            foreach ($team->getParticipants() as $participant) {
                if ($participant->getId() == $participantId) {
                    $participant->setPlayer($player);
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @return TeamColor
     */
    public function getWinnerTeamColor(): TeamColor
    {
        return $this->winnerTeamColor;
    }

    public function championIsBanned(Champion $champion): bool
    {

        /** @var Team $team */
        foreach ($this->teams as $team) {
            if ($team->hasBannedChampion($champion)) {
                return true;
            }
        }

        return false;
    }

    public function hasChampionWon(Champion $champion) : bool
    {
        /** @var Team $team */
        foreach ($this->teams as $team) {
            if($team->getColor()->value === $this->winnerTeamColor->value && $team->hasPickedChampion($champion)){
                return true;
            }
        }

        return false;
    }

    public function hasPlayerWon(Player $player)
    {
        /** @var Team $team */
        foreach ($this->teams as $team) {
            if($team->getColor()->value === $this->winnerTeamColor->value && $team->hasPlayer($player)){
                return true;
            }
        }
    }


}