<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Provider;
use App\Subscription;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
        Provider::saved(function ($provider) {
            if ($provider->status == 'active' && $provider->draft == 0) {
                
                $provider->load('state');

                $subscriptions = Subscription::where('state_id', $provider->state_id)
                    ->where('city', $provider->city)
                    ->where('notified', 0)
                    ->get();
                    
                $subscriptions->each(function($subscription) use ($provider){
                    Mail::to($subscription->email)
                        ->queue(new SubscriptionNotification($provider));
                    $subscription->notified = true;
                    $subscription->save();
                });
            }
        });
    }
}
