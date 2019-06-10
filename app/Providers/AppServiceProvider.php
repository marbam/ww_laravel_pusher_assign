<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('notInGame', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            $game = \App\Game::where('code', $data['code'])->first();
            if ($game) {
                $playerExists = \App\Player::where('name', $value)->count();
                if (!$playerExists) {
                    return true;
                }
            }
            return false;
        });
    }
}
