<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
