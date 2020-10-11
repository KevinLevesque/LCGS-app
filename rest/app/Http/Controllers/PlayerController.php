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
}
