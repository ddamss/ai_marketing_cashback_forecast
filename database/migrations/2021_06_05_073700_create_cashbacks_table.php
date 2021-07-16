<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbacks', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string('token')
                ->foreign('token')
                ->references('token')->on('accounts')
                ->onDelete('cascade');
            $table->integer("page");
            $table->float("cashback");
            $table->integer("payment_delay");
            $table->float("sale_amount");
            $table->float("cashback_rate");
            $table->string("payment_status");
            $table->dateTime("sale_date");
            $table->boolean("first_item");
            $table->integer("row_id");
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
        Schema::dropIfExists('cashbacks');
    }
}
