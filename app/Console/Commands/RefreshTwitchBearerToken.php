<?php

namespace App\Console\Commands;

use App\Dtos\BearerToken;
use Illuminate\Console\Command;
use App\Services\TwitchTokenService;
use App\Managers\Twitch\TwitchManager;

class RefreshTwitchBearerToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh-twitch-bearer-token {--show}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        protected TwitchManager $twitchManager, 
        protected TwitchTokenService $twitchTokenService,
    ){
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bearerToken = $this->twitchManager->getBearerToken();

        $this->twitchTokenService->save($bearerToken);

        $this->success($bearerToken);

        $this->comment("Don't forget restart queue : php artisan queue:restart");

        return Command::SUCCESS;
    }

    protected function success(BearerToken $bearerToken): void
    {
        $message = 'Twitch bearer token successfully refreshed';

        if ($this->option('show')) {
            $message .= ' : ' . $bearerToken->value;  
        }

        $this->info($message);
    }
}
