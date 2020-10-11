<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use KLevesque\LCGS\Services\MatchService;

class SyncMatchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:match {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync a LoL Match by ID';
    /**
     * @var MatchService
     */
    private MatchService $matchService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MatchService $matchService)
    {
        parent::__construct();
        $this->matchService = $matchService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->matchService->syncMatch($this->argument("id"));
    }
}
