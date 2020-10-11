<?php

namespace App\Providers;

use AutoMapperPlus\AutoMapper;
use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\Configuration\AutoMapperConfig;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use AutoMapperPlus\MappingOperation\Operation;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;
use KLevesque\LCGS\Domain\Champion\Champion;
use KLevesque\LCGS\Domain\Champion\ChampionRepository;
use KLevesque\LCGS\Domain\Champion\ChampionStats;
use KLevesque\LCGS\Domain\Match\Match;
use KLevesque\LCGS\Domain\Match\MatchRepository;
use KLevesque\LCGS\Domain\Match\Participant;
use KLevesque\LCGS\Domain\Match\Team;
use KLevesque\LCGS\Domain\Match\TeamColor;
use KLevesque\LCGS\Domain\Player\Player;
use KLevesque\LCGS\Domain\Player\PlayerRepository;
use KLevesque\LCGS\Infrastructure\persistence\doctrine\DoctrineChampionRepository;
use KLevesque\LCGS\Infrastructure\persistence\doctrine\DoctrineMatchRepository;
use KLevesque\LCGS\Infrastructure\persistence\doctrine\DoctrinePlayerRepository;
use KLevesque\LCGS\Infrastructure\persistence\doctrine\EntityManager;
use KLevesque\LCGS\Infrastructure\RiotApi\RiotApi;
use KLevesque\LCGS\Services\Dto\ChampionDto;
use KLevesque\LCGS\Services\Dto\ChampionStatsDto;
use KLevesque\LCGS\Services\Dto\MatchDto;
use KLevesque\LCGS\Services\Dto\ParticipantDto;
use KLevesque\LCGS\Services\Dto\PlayerDto;
use KLevesque\LCGS\Services\Dto\TeamDto;
use RiotAPI\LeagueAPI\Definitions\Region;
use RiotAPI\LeagueAPI\LeagueAPI;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $dbConn = array(
            'driver' => env('DB_DRIVER'),
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'user' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'dbname' => env('DB_DATABASE'),
        );


        $this->app->singleton(RiotApi::class, function () {
            return new RiotApi(
                new \RiotAPI\LeagueAPI\LeagueAPI([
                    LeagueAPI::SET_DATADRAGON_INIT => true,
                    LeagueAPI::SET_KEY => env('LEAGUE_API_KEY'),
                    LeagueAPI::SET_REGION => Region::NORTH_AMERICA
                ])
            );

        });


        $this->app->singleton(EntityManagerInterface::class, function ($app) use ($dbConn) {
            return EntityManager::creer($dbConn, storage_path('Proxies'));
        });


        $this->app->singleton(ChampionRepository::class, DoctrineChampionRepository::class);
        $this->app->singleton(MatchRepository::class, DoctrineMatchRepository::class);
        $this->app->singleton(PlayerRepository::class, DoctrinePlayerRepository::class);

        $config = new AutoMapperConfig();


        $config->registerMapping(Match::class, MatchDto::class)
            ->forMember('teams', Operation::mapCollectionTo(TeamDto::class))
            ->forMember('winnerTeamColor', fn(Match $match) => $match->getWinnerTeamColor()->value)
            ->forMember('date', fn(Match $match) => $match->getDate()->format(DATE_ISO8601));

        $config->registerMapping(Team::class, TeamDto::class)
            ->forMember('color', fn(Team $team) => $team->getColor()->value)
            ->forMember('participants', Operation::mapCollectionTo(ParticipantDto::class));

        $config->registerMapping(Participant::class, ParticipantDto::class)
            ->forMember('champion', Operation::mapTo(ChampionDto::class))
            ->forMember('player', Operation::mapTo(PlayerDto::class));

        $config->registerMapping(Player::class, PlayerDto::class);

        $config->registerMapping(Champion::class, ChampionDto::class);

        $config->registerMapping(ChampionStats::class, ChampionStatsDto::class)
            ->forMember('champion', Operation::mapTo(ChampionDto::class));

        $this->app->singleton(AutoMapperInterface::class, fn() => new AutoMapper($config));
    }
}
