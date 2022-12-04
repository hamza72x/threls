<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // user_id = seller_id
            $table->unsignedBigInteger('user_id');
            $table->string('name')->index();
            // brand: this should've been a separate table & this column should've been a foreign key
            // just using string for the sake of simplicity
            $table->string('brand')->index();
            $table->double('price');
            $table->timestamps();
        });

        // foreign to users (seller type) id
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // drop foreign to users (seller type) id
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('products');
    }
};
