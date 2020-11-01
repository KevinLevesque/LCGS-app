<?php

namespace KLevesque\LCGS\Services;

use AutoMapperPlus\AutoMapperInterface;
use KLevesque\LCGS\Domain\Champion\ChampionRepository;
use KLevesque\LCGS\Domain\Match\Match;
use KLevesque\LCGS\Domain\Match\MatchRepository;
use KLevesque\LCGS\Domain\Match\TeamColor;
use KLevesque\LCGS\Domain\Player\PlayerRepository;
use KLevesque\LCGS\Infrastructure\RiotApi\RiotApi;
use KLevesque\LCGS\Services\Dto\MatchDto;

class MatchService
{
    private RiotApi $riotApi;
    private ChampionRepository $championRepository;
    /**
     * @var MatchRepository
     */
    private MatchRepository $matchRepository;
    /**
     * @var AutoMapperInterface
     */
    private AutoMapperInterface $mapper;
    /**
     * @var PlayerRepository
     */
    private PlayerRepository $playerRepository;

    public function __construct(RiotApi $riotApi, ChampionRepository $championRepository, MatchRepository $matchRepository, PlayerRepository $playerRepository, AutoMapperInterface $mapper)
    {
        $this->riotApi = $riotApi;
        $this->championRepository = $championRepository;
        $this->matchRepository = $matchRepository;
        $this->mapper = $mapper;
        $this->playerRepository = $playerRepository;
    }


    public function syncMatch(int $matchId)
    {

        $apiMatch = $this->riotApi->getMatch($matchId);
        $date = \DateTime::createFromFormat('U', round($apiMatch->gameCreation / 1000))->setTimezone(new \DateTimeZone(date_default_timezone_get()));

        $winnerTeamColor = $apiMatch->teams[0]->win == "Win" ? TeamColor::blue() : TeamColor::red();

        $match = new Match($apiMatch->gameId, $date, $winnerTeamColor);

        foreach ($apiMatch->participants as $participant) {

            $teamColor = $participant->teamId == 100 ? TeamColor::blue() : TeamColor::red();
            $match->addTeamParticipant($teamColor, null, $this->championRepository->getChampion($participant->championId), $participant->stats->kills, $participant->stats->deaths, $participant->stats->assists, $participant->stats->totalDamageDealtToChampions, $participant->timeline->role, $participant->timeline->lane);
        }

        foreach ($apiMatch->teams[0]->bans as $ban) {
            $match->addTeamChampionBan(TeamColor::blue(), $this->championRepository->getChampion($ban->championId));
        }

        foreach ($apiMatch->teams[1]->bans as $ban) {
            $match->addTeamChampionBan(TeamColor::red(), $this->championRepository->getChampion($ban->championId));
        }

        $this->matchRepository->save($match);


    }

    public function getMatch(int $matchId) : MatchDto
    {
        $match = $this->matchRepository->getMatch($matchId);
        return $this->mapper->map($match, MatchDto::class);
    }

    public function getAllMatches() {
        $allMatches = $this->matchRepository->getAll();
        return $this->mapper->mapMultiple($allMatches, MatchDto::class);
    }

    public function setParticipantPlayer($matchId, $participantId, $playerUsername)
    {
        $player = $this->playerRepository->getPlayer($playerUsername);
        $match = $this->matchRepository->getMatch($matchId);
        $match->setPlayer($participantId, $player);

        $this->matchRepository->save($match);
    }

    public function getMatchesAmount()
    {
        return $this->matchRepository->getMatchesAmount();
    }
}
