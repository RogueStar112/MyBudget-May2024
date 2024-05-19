<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCategoryTable07022022 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        /*
        Schema::create('mybudget_category', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->default('');
            $table->decimal('budget', $precision = 8, $scale = 2)->default(0.00);
            $table->decimal('cost', $precision = 8, $scale = 2)->default(0.00);
            $table->date('created_at');
        });
        */

        Schema::table('mybudget_category', function (Blueprint $table) {
            $table->string('color-bg', 7)->default('#008000');
            $table->string('color-text', 7)->default('#000000');
            $table->string('icon-code', 7)->default('&#xf07a;');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
