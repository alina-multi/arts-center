<?php

namespace App\Providers;

use App\Blog;
use App\Policies\MultipeOwnersPolicy;
use App\Work;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Blog::class => MultipeOwnersPolicy::class,
        Work::class => MultipeOwnersPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //
    }
}
