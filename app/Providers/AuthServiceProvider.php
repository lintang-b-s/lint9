<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::resource('blog_post',
        'App\Models\Policies\BlogPostPolicy');

        Gate::resource('tag',
        'App\Models\Policies\TagPolicy');

        Gate::resource('post_comment',
        'App\Models\Policies\PostCommentPolicy'
    );

        // Gate::resource('blog_post',
        // 'App\')
        // //
    }
}
