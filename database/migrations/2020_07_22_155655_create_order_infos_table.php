<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_infos', function (Blueprint $table) {
            $table->id();

            $table->smallInteger('user_id');

            $table->string('ship_name')->nullable();
            $table->string('ship_mobile')->nullable();
            $table->string('ship_address_1')->nullable();
            $table->string('ship_address_2')->nullable();
            $table->string('ship_city')->nullable();
            $table->string('ship_state')->nullable();

            $table->string('bill_name')->nullable();
            $table->string('bill_mobile')->nullable();
            $table->string('bill_address_1')->nullable();
            $table->string('bill_address_2')->nullable();
            $table->string('bill_city')->nullable();
            $table->string('bill_state')->nullable();

            $table->string('transaction_id')->nullable();
            $table->string('currency')->nullable();

            $table->smallInteger('orderd_items');
            $table->decimal('amount', 8, 2)->nullable();
            $table->decimal('shipping_charge', 8, 2)->nullable();
            $table->decimal('payment_amount', 8, 2)->nullable();
            $table->string('payment_status')->nullable();
            $table->string('order_status', 52)->nullable();
            
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
        Schema::dropIfExists('order_infos');
    }
}
