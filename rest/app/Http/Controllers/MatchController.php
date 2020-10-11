<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use KLevesque\LCGS\Services\MatchService;
use RiotAPI\DataDragonAPI\DataDragonAPI;
use RiotAPI\LeagueAPI\Definitions\Region;
use RiotAPI\LeagueAPI\LeagueAPI;

class MatchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private MatchService $matchService;

    public function __construct(MatchService $matchService)
    {
        $this->matchService = $matchService;
    }

    public function syncMatch(Request $request)
    {
        $this->matchService->syncMatch((int)$request->get('matchId'));
    }

    public function getMatch($id)
    {
        $match = $this->matchService->getMatch((int)$id);
        return response()->json($match);
    }

    public function getMatches()
    {
        $match = $this->matchService->getAllMatches();
        return response()->json($match);
    }

    public function setPlayer($matchId, $participantId, Request $request) {
        $this->matchService->setParticipantPlayer($matchId, $participantId, $request->get('username'));
    }
}
