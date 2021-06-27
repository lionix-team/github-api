<?php

namespace App\Providers;

use App\Contracts\GithubApi;
use App\Services\GithubApiService;
use Illuminate\Support\ServiceProvider;

class GithubServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(GithubApi::class, GithubApiService::class);
    }
}
