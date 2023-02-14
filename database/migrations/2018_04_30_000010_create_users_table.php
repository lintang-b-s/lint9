<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    const TABLE_NAME = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(static::TABLE_NAME, function (Blueprint $table) {
            $table->uuid('user_id');

            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->uuid('primary_role')->nullable();
            $table->foreign('primary_role')->references('role_id')->on('roles')->onDelete('set null');

            $table->primary('user_id');
            $table->boolean('is_admin')->default(false);
            $table->string('address');
            $table->string('phone');
            $table->string('credit_card_type')->nullable();
            $table->string('credit_card_number')->nullable();
            $table->string('cc_expiration_month')->nullable();
            $table->string('cc_expiration_year')->nullable();
            
        
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(static::TABLE_NAME);
    }
}
