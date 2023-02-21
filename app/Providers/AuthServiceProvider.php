<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Discount;
use App\Models\ProductCategory;
use App\Models\Cart;
use App\Models\Policies\CategoryPolicy;
use App\Models\Policies\ProductPolicy;
use App\Models\Policies\DiscountPolicy;
use App\Models\Policies\ProductCategoryPolicy;
use App\Models\Policies\CartPolicy;

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
        Product::class => ProductPolicy::class,
        Discount::class => DiscountPolicy::class,
        ProductCategory::class => ProductCategoryPolicy::class,
        Cart::class => CartPolicy::class,



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
        Gate::resource('products',
        'App\Models\Policies\ProductPolicy');

        Gate::resource('discounts',
        'App\Models\Policies\DiscountPolicy');
        
        Gate::resource('product_categories',
        'App\Models\Policies\ProductCategoryPolicy');


        Gate::resource('carts',
        'App\Models\Policies\CartPolicy');

        
    }
}
