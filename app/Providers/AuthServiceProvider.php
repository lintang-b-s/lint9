<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Policies\CategoryPolicy;
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
        Category::class => CategoryPolicy::class,

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

        Gate::resource('blog_posts',
        'App\Models\Policies\BlogPostPolicy');

        Gate::resource('tags',
        'App\Models\Policies\TagPolicy');

        Gate::resource('post_comments',
        'App\Models\Policies\PostCommentPolicy');

        Gate::resource('categories',
        'App\Models\Policies\CategoryPolicy');
        

        
    }
}
