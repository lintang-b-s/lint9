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
        $this->call(OrderDetailsSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(SuppliersSeeder::class);
    }
}
