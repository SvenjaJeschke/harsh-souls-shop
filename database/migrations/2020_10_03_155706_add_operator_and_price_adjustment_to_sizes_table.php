<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOperatorAndPriceAdjustmentToSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sizes', function (Blueprint $table) {
            $table->string('operator')->nullable();
            $table->decimal('price_adjustment', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sizes', function (Blueprint $table) {
            $table->dropColumn('operator');
            $table->dropColumn('price_adjustment');
        });
    }
}
