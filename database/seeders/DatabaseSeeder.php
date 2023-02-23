<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UserStorySeeder::class);
        $this->call(BlogPostsSeeder::class);
        $this->call(PostCommentsSeeder::class);
        $this->call(TagsSeeder::class);
        $this->call(PostTagsSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(PostCategoriesSeeder::class);
        $this->call(OrdersSeeder::class);
        $this->call(ShippersSeeder::class);
        $this->call(PaymentsSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(SuppliersSeeder::class);
        $this->call(UserPaymentsSeeder::class);
        $this->call(UserAddressesSeeder::class);
        $this->call(DiscountsSeeder::class);
        $this->call(OrderItemsSeeder::class);
        $this->call(CartsSeeder::class);
        $this->call(CartItemsSeeder::class);
        $this->call(ProductReviewsSeeder::class);
        $this->call(TransactionsSeeder::class);
        $this->call(PivotProductCategoriesSeeder::class);
        $this->call(SupplierTypesSeeder::class);
        $this->call(WishlistsSeeder::class);
        $this->call(OrderStatusesSeeder::class);
        $this->call(ShipmentTypesSeeder::class);
        $this->call(ShipmentStatusesSeeder::class);
        $this->call(ShipmentsSeeder::class);
    }
}
