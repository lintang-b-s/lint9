<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('contact_name');
            $table->string('contact_title');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('payment_method')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('type_goods')->nullable();
            $table->string('notes')->nullable();
            $table->longText('logo')->nullable();
            $table->uuid('customer_id');
            $table->foreign('customer_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');


            // $table->foreignId('customer_id')->nullable()->index('fk_suppliers_to_users');
            // $table->foreign('customer_id', 'fk_suppliers_to_users')->references('user_id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');

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
        Schema::dropIfExists('suppliers');
    }
}
