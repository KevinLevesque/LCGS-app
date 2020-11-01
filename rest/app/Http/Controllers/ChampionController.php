<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use KLevesque\LCGS\Services\ChampionService;
use KLevesque\LCGS\Services\MatchService;
use KLevesque\LCGS\Services\PlayerService;
use RiotAPI\DataDragonAPI\DataDragonAPI;
use RiotAPI\LeagueAPI\Definitions\Region;
use RiotAPI\LeagueAPI\LeagueAPI;

class ChampionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private ChampionService $championService;

    public function __construct(ChampionService $championService)
    {
        $this->championService = $championService;
    }




    public function getAllStats() {
        $champions = $this->championService->getChampionsStats();
        return response()->json($champions);
    }

    public function getStats($name) {
        $name = urldecode($name);
        $champions = $this->championService->getChampionStats($name);
        return response()->json($champions);
    }

    public function getMatches($name){
        $name = urldecode($name);
        return response()->json(
          $this->championService->getMatches($name)
        );
    }
}
