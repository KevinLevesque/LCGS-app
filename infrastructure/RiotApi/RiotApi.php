<?php


namespace KLevesque\LCGS\Infrastructure\RiotApi;


use RiotAPI\LeagueAPI\Exceptions\GeneralException;
use RiotAPI\LeagueAPI\Exceptions\RequestException;
use RiotAPI\LeagueAPI\Exceptions\ServerException;
use RiotAPI\LeagueAPI\Exceptions\ServerLimitException;
use RiotAPI\LeagueAPI\Exceptions\SettingsException;
use RiotAPI\LeagueAPI\LeagueAPI;
use RiotAPI\LeagueAPI\Objects\StaticData\StaticChampionDto;

class RiotApi
{

    /**
     * @var LeagueAPI
     */
    private LeagueAPI $leagueAPI;

    public function __construct(LeagueAPI $leagueAPI)
    {
        $this->leagueAPI = $leagueAPI;
    }


    /**
     * @param int $id
     * @throws GeneralException
     * @throws RequestException
     * @throws ServerException
     * @throws ServerLimitException
     * @throws SettingsException
     */
    public function getMatch(int $id){
        return $this->leagueAPI->getMatch($id);
    }

    public function getChampion(int $id) : StaticChampionDto{
        return $this->leagueAPI->getStaticChampion($id);
    }

    public function getSummoner($username)
    {
        return $this->leagueAPI->getSummonerByName($username);
    }

}