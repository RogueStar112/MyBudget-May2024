<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMyBudgetTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create mybudget_item table
        Schema::create('mybudget_item', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->default('');
            $table->decimal('price', 8, 2)->default(0.00);
            $table->timestamps();
            $table->string('description', 300)->default('');
            $table->boolean('has_subtransactions')->default(0);
            $table->softDeletes();
        });

        // Create mybudget_source table
        Schema::create('mybudget_source', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->default('');
            $table->timestamps();
        });

        // Create mybudget_category table
        Schema::create('mybudget_category', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->default('');
            $table->timestamps();
            $table->string('color_bg', 7)->default('#008000');
            $table->string('color_text', 7)->default('#000000');
            $table->string('icon_code', 8)->default('&#xf07a;');
        });

        // Create mybudget_section table
        Schema::create('mybudget_section', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->default('');
            $table->timestamps();
            $table->foreignId('category_id')->constrained('mybudget_category')->onDelete('cascade');
        });

        // Create mybudget_budget table
        Schema::create('mybudget_budget', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->default('');
            $table->decimal('budget', 8, 2)->default(0.00);
            $table->decimal('cost', 8, 2)->default(0.00);
            $table->decimal('balance_spent', 8, 2)->default(0.00);
            $table->decimal('balance_left', 8, 2)->default(0.00);
            $table->timestamps();
        });

        // Add foreign keys to mybudget_item table
        Schema::table('mybudget_item', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('mybudget_category')->onDelete('cascade');
            $table->foreignId('section_id')->nullable()->constrained('mybudget_section')->onDelete('cascade');
            $table->foreignId('source_id')->nullable()->constrained('mybudget_source')->onDelete('cascade');
        });

        // Create mybudget_subtransactions table
        Schema::create('mybudget_subtransactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('price', 8, 2)->default(0.00);
            $table->string('description', 300)->default('');
            $table->string('name', 100)->default('');
            $table->foreignId('category_id')->nullable()->constrained('mybudget_category')->onDelete('cascade');
            $table->foreignId('section_id')->nullable()->constrained('mybudget_section')->onDelete('cascade');
            $table->foreignId('transaction_id')->nullable()->constrained('mybudget_item')->onDelete('cascade');
            $table->foreignId('source_id')->nullable()->constrained('mybudget_source')->onDelete('cascade');
        });


        // adding user_id

        Schema::table('mybudget_category', function (Blueprint $table) {
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });


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

        Schema::table('mybudget_source', function (Blueprint $table) {
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
        Schema::dropIfExists('mybudget_subtransactions');
        Schema::dropIfExists('mybudget_item');
        Schema::dropIfExists('mybudget_source');
        Schema::dropIfExists('mybudget_category');
        Schema::dropIfExists('mybudget_section');
        Schema::dropIfExists('mybudget_budget');
    }
}