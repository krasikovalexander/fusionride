<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Provider;

class Ratings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ratings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trying to get providers ratings';

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
        Provider::withTrashed()->whereNotNull('lat')->chunk(100, function ($providers) {
            $providers->each(function ($provider) {
                $save = false;
                if (!$provider->google_place_id) {
                    $provider->google_place_id = $provider->getPlaceIdByAddressName($provider->address, $provider->name);
                    $save = $provider->google_place_id !== null;
                }
                if ($provider->google_place_id) {
                    $provider->google_review_rating = $provider->getGoogleRatingByPlaceID($provider->google_place_id);
                    $save = $save || $provider->google_review_rating !== null;
                }
                if ($save) {
                    $provider->save();
                }
            });
        });
    }
}
