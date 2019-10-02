<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('invoice_id')
                ->nullable();
            $table->string('tax_invoice_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->dateTime('transaction_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('invoice_id');
        });

        DB::statement('ALTER table transactions PARTITION BY HASH(id) PARTITIONS 20;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
