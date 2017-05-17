<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Provider;

class Geocode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geocode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trying to get providers coordinates by address';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Provider::withTrashed()->chunk(100, function ($providers) {
            $providers->each(function ($provider) {
                $provider->geocode(true);
            });
        });
    }
}
