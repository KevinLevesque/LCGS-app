<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use KLevesque\LCGS\Services\MatchService;
use KLevesque\LCGS\Services\PlayerService;
use RiotAPI\DataDragonAPI\DataDragonAPI;
use RiotAPI\LeagueAPI\Definitions\Region;
use RiotAPI\LeagueAPI\LeagueAPI;

class PlayerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private PlayerService $playerService;

    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }


    public function addPlayer(Request $request)
    {
        $player = $this->playerService->addPlayer($request->get('username'));
        return response()->json($player);
    }

    public function getAll() {
        $players = $this->playerService->getAll();
        return response()->json($players);
    }

    public function getAllStats(){
        return response()->json(
            $this->playerService->getAllStats()
        );
    }

    public function getStats($username){
        $username = urldecode($username);
        return response()->json(
            $this->playerService->getStats($username)
        );
    }

    public function getMatches($username){
        $username = urldecode($username);
        return response()->json(
            $this->playerService->getMatches($username)
        );
    }
}
