<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Discount;
use App\Models\ProductCategory;
use App\Models\Cart;
use App\Models\ShipmentType;
use App\Models\Payment;
use App\Models\Supplier;
use App\Models\User;
use App\Models\UserPayment;
use App\Models\Order;
use App\Models\Shipper;
use App\Models\UserAddress;
use App\Models\SupplierType;
use App\Models\Wishlist;
use App\Models\Policies\CategoryPolicy;
use App\Models\Policies\ProductPolicy;
use App\Models\Policies\DiscountPolicy;
use App\Models\Policies\ProductCategoryPolicy;
use App\Models\Policies\CartPolicy;
use App\Models\Policies\ShipmentTypePolicy;
use App\Models\Policies\PaymentPolicy;
use App\Models\Policies\SupplierPolicy;
use App\Models\Policies\UserPolicy;
use App\Models\Policies\UserPaymentPolicy;
use App\Models\Policies\OrderPolicy;
use App\Models\Policies\ShipperPolicy;
use App\Models\Policies\UserAddressPolicy;
use App\Models\Policies\SupplierTypePolicy;
use App\Models\Policies\WishlistPolicy;


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
        ShipmentType::class => ShipmentTypePolicy::class,
        Payment::class => PaymentPolicy::class,
        Supplier::class => SupplierPolicy::class,
        User::class => UserPolicy::class,
        UserPayment::class => UserPaymentPolicy::class,
        Shipper::class => ShipperPolicy::class,
        UserAddress::class => UserAddressPolicy::class,
        SupplierType::class => SupplierTypePolicy::class,
        Wishlist::class => WishlistPolicy::class

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

        Gate::resource('shipment_types',
        'App\Models\Policies\ShipmentTypePolicy');

        Gate::resource('payments',
        'App\Models\Policies\PaymentPolicy');

        Gate::resource('suppliers',
        'App\Models\Policies\SupplierPolicy');

        Gate::resource('users',
        'App\Models\Policies\UserPolicy');

        Gate::resource('user_payments', 
        'App\Models\Policies\UserPaymentPolicy');

        Gate::resource('orders', 
        'App\Models\Policies\OrderPolicy');

        Gate::resource('shippers',
        'App\Models\Policies\ShipperPolicy');
        
        Gate::resource('user_addresses',
        'App\Models\Policies\UserAddressPolicy');

        Gate::resource('supplier_types',
        'App\Models\Policies\SupplierTypePolicy');
        
        Gate::resource('wishlists',
        'App\Models\Policies\WishlistPolicy');
    }
}
