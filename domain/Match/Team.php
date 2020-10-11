<?php
namespace KLevesque\LCGS\Domain\Match;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use KLevesque\LCGS\Domain\Champion\Champion;
use KLevesque\LCGS\Domain\Player\Player;

class Team
{

    private string $id;
    private TeamColor $color;
    private Collection $participants;
    private Collection $championsBans;


    public function __construct(TeamColor $teamColor)
    {
        $this->id = uniqid();

        $this->participants = new ArrayCollection();
        $this->championsBans = new ArrayCollection();

        $this->color = $teamColor;
    }

    public function addParticipant(Participant $participant){
        $this->participants->add($participant);
    }

    public function addChampionBan(Champion $champion){
        $this->championsBans->add($champion);
    }

    public function hasPlayer(Player $player) : bool {
        /** @var Participant $participant */
        foreach ($this->participants as $participant){
            if($participant->getPlayer() === $player){
                return true;
            }
        }

        return false;

    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Collection
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    /**
     * @return Collection
     */
    public function getChampionsBans(): Collection
    {
        return $this->championsBans;
    }

    /**
     * @return TeamColor
     */
    public function getColor(): TeamColor
    {
        return $this->color;
    }

    public function hasPickedChampion(Champion $champion) : bool{

        /** @var Participant $participant */
        foreach ($this->participants as $participant) {
            if($participant->getChampion()->getId() === $champion->getId()){
                return true;
            }
        }

        return false;
    }

    public function hasBannedChampion(Champion $champion)
    {
        /** @var Champion $championsBan */
        foreach ($this->championsBans as $championsBan){
            if($championsBan === $champion){
                return true;
            }
        }

        return false;
    }


}