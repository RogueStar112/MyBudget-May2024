<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyMybudgetSubtransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mybudget_subtransactions', function (Blueprint $table) {
            //$table->string('name', 100)->default('');
            //$table->string('description', 300)->nullable()->change();
            //$table->foreignId('category_id')->constrained('mybudget_category')->onDelete('cascade');
            //$table->foreignId('section_id')->constrained('mybudget_section')->onDelete('cascade');
            //$table->foreignId('transaction_id')->constrained('mybudget_item')->onDelete('cascade');
            $table->foreignId('source_id')->constrained('mybudget_source')->onDelete('cascade');
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
