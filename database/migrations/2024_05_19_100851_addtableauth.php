<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Addtableauth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::rollBack();
        // just adding user_id reference to all mybudget tables.

        // Schema::table('mybudget_source', function (Blueprint $table) {
        //     $table->integer('user_id');
        //     $table->foreign('user_id')->references('id')->on('users');
        // });

        DB::table('mybudget_category')->delete();

        Schema::table('mybudget_category', function (Blueprint $table) {
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });

        DB::table('mybudget_section')->delete();

        Schema::table('mybudget_section', function (Blueprint $table) {
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });


        Schema::table('mybudget_budget', function (Blueprint $table) {
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });


        Schema::table('mybudget_item', function (Blueprint $table) {
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });


        Schema::table('mybudget_subtransactions', function (Blueprint $table) {
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
