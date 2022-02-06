<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Relations\Relation;
use Laravel\Telescope\Telescope;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Telescope::ignoreMigrations();
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Relation::morphMap(
            [
                'work' => 'App\Work',
                'comment' => 'App\Comment',
                'user' => 'App\User',
                'feedback' => 'App\Feedback',
                'tag' => 'App\Tag',
                'blog' => 'App\Blog',
                'post' => 'App\Post',
            ]
        );
    }
}
