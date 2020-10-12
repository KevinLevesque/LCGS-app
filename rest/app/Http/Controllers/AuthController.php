<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use KLevesque\LCGS\Services\MatchService;
use RiotAPI\DataDragonAPI\DataDragonAPI;
use RiotAPI\LeagueAPI\Definitions\Region;
use RiotAPI\LeagueAPI\LeagueAPI;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {

        if ($request->get('password') != env('ADMIN_PASSWORD')) {
            return response(['error' => ''], 401);
        }


        return response()->json(['token' => $this->generateToken()]);
    }

    public function refreshToken(Request $request)
    {
        return response()->json(['token' => $this->generateToken()]);
    }

    private function generateToken()
    {
        return JWT::encode([
            'user' => 'Admin',
            'exp' => Carbon::now()->addDays(7)->unix()
        ], env('JWT_KEY'));
    }
}
