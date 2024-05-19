<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMybudgetDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::table('mybudget_item', function (Blueprint $table) {
            //$table->string('name', 30)->default('');
            //$table->decimal('price', $precision = 8, $scale = 2)->default(0.00);
            //$table->date('created_at');
        //});

        //Schema::create('mybudget_source', function (Blueprint $table) {
            //$table->id();
            //$table->string('name', 30)->default('');
            //$table->date('created_at');
        //});

        //Schema::table('users', function (Blueprint $table) {
            //$table->integer('source_id');
            
            //$table->foreign('source_id')->references('id')->on('mybudget_item');


        //});
        
        /*
        Schema::create('mybudget_category', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->default('');
            //$table->decimal('budget', $precision = 8, $scale = 2)->default(0.00);
            //$table->decimal('cost', $precision = 8, $scale = 2)->default(0.00);
            $table->date('created_at');
        });

        Schema::create('mybudget_section', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->default('');
            //$table->decimal('budget', $precision = 8, $scale = 2)->default(0.00);
            //table->decimal('cost', $precision = 8, $scale = 2)->default(0.00);
            $table->date('created_at');
        });
        */

        Schema::table('mybudget_section', function (Blueprint $table) {
            //$table->integer('category_id')->default(0);
            
            $table->foreign('category_id')->references('id')->on('mybudget_category')->onDelete('cascade');;
        });
        
        /*
        Schema::create('mybudget_budget', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->default('');
            $table->decimal('budget', $precision = 8, $scale = 2)->default(0.00);
            $table->decimal('cost', $precision = 8, $scale = 2)->default(0.00);
            $table->decimal('balance-spent', $precision = 8, $scale = 2)->default(0.00);
            $table->decimal('balance-left', $precision = 8, $scale = 2)->default(0.00);

            $table->date('created_at');
        });
        */

        Schema::table('mybudget_item', function (Blueprint $table) {
            //$table->integer('category_id')->default(0);
            $table->foreign('category_id')->references('id')->on('mybudget_category')->onDelete('cascade');;

            //$table->integer('section_id')->default(0);
            $table->foreign('section_id')->references('id')->on('mybudget_section')->onDelete('cascade');;
            
            //$table->integer('source_id')->default(0);
            $table->foreign('source_id')->references('id')->on('mybudget_source')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mybudget_db');
    }
}
