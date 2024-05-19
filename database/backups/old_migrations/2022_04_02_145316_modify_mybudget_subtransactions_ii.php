<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyMybudgetSubtransactionsIi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        /*
        Schema::table('mybudget_subtransactions', function (Blueprint $table) {

            $table->integer('source_id')->nullable(false)->default('');

        });
        */

        Schema::create('mybudget_subtransactions', function (Blueprint $table) {
            /*
            $table->id();
            $table->timestamps();
            $table->decimal('price', $precision = 8, $scale = 2);
            $table->string('description', 300);
            $table->integer('category_id');
            $table->integer('section_id')->nullable(false)->default('');
            $table->integer('transaction_id')->nullable(false)->default('');
            $table->integer('source_id')->nullable(false)->default('');
            */

        });

        Schema::table('mybudget_subtransactions', function (Blueprint $table) {
            $table->string('name', 100)->default('');
            $table->foreign('category_id')->references('id')->on('mybudget_category')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('mybudget_section')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('mybudget_item')->onDelete('cascade');
            $table->foreign('source_id')->references('id')->on('mybudget_source')->onDelete('cascade');
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
