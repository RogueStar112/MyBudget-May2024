<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMybudgetSubtransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('mybudget_item', function (Blueprint $table) {
            $table->boolean('has_subtransactions')->default(0);
        });

        Schema::create('mybudget_subtransactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('cost', $precision = 8, $scale = 2);
            $table->string('description', 300);
            $table->integer('category_id');
            $table->integer('section_id');
            $table->integer('transaction_id');
        });

        Schema::table('mybudget_subtransactions', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('mybudget_category')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('mybudget_section')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('mybudget_item')->onDelete('cascade');
        });

        Schema::create('mybudget_sectionbudget', function (Blueprint $table) {
            $table->id();
            $table->decimal('budget', $precision = 8, $scale = 2);
            $table->date('date_start');
            $table->date('date_end');
            $table->integer('category_id');
            $table->integer('section_id');

        });

        Schema::table('mybudget_sectionbudget', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('mybudget_category')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('mybudget_section')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mybudget_subtransactions');
    }
}
