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
                'work' => 'App\Models\Work',
                'comment' => 'App\Models\Comment',
                'user' => 'App\Models\User',
                'feedback' => 'App\Models\Feedback',
                'tag' => 'App\Models\Tag',
                'blog' => 'App\Models\Blog',
                'post' => 'App\Models\Post',
            ]
        );
    }
}
