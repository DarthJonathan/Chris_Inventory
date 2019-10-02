<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id');
            $table->integer('product_id');
            $table->integer('queue_id')->nullable();
            $table->integer('stock_in_queue')->nullable();
            $table->string('product_name')->nullable();
            $table->text('description')->nullable();
            $table->integer('stock')->nullable();
            $table->float('price')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['transaction_id', 'product_id', 'id']);
        });

        DB::statement('ALTER table inventory_logs PARTITION BY HASH(id) PARTITIONS 20;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_logs');
    }
}
