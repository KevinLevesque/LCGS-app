<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use RiotAPI\LeagueAPI\Definitions\Region;
use RiotAPI\LeagueAPI\LeagueAPI;


$router->post('/auth', "AuthController@authenticate");
$router->post('/auth-refresh', ['middleware' => 'auth', 'uses' => "AuthController@refreshToken"]);


$router->get('/', function () use ($router) {

    return $router->app->version();
});

$router->get('/matches', "MatchController@getMatches");
$router->get('/matches/{id}', "MatchController@getMatch");
$router->post('/matches/sync', ['middleware' => 'auth', 'uses' => "MatchController@syncMatch"]);
$router->post('/matches/{matchId}/participants/{participantId}/setPlayer', ['middleware' => 'auth', 'uses' => "MatchController@setPlayer"]);

$router->post('/players', ['middleware' => 'auth', 'uses' => "PlayerController@addPlayer"]);
$router->get('/players', "PlayerController@getAll");
$router->get('/players/stats', "PlayerController@getAllStats");


$router->get('/champions/stats', "ChampionController@getAllStats");



