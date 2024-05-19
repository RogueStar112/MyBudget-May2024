<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyjournalTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::enableForeignKeyConstraints();

        /*
        Schema::create('myjournal_entries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id');
            $table->string('content', 10000);
            $table->boolean('is_bookmarked')->default(0);
        });

        Schema::table('myjournal_tags', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            
        });

        Schema::create('myjournal_tags', function (Blueprint $table) {
            $table->id();
            $table->integer('entry_id');
            $table->integer('user_id');
        });

        Schema::table('myjournal_tags', function (Blueprint $table) {
            $table->foreign('entry_id')->references('id')->on('myjournal_entries');
            $table->foreign('user_id')->references('id')->on('users');

        });

        Schema::create('myjournal_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id');
            $table->integer('entry_id');
        });

        Schema::table('myjournal_bookmarks', function (Blueprint $table) {
            $table->foreign('entry_id')->references('id')->on('myjournal_entries');
            $table->foreign('user_id')->references('id')->on('users');

        });
        */

        /*
        Schema::create('myjournal_entries_tags', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('tag_id');
            $table->integer('entry_id');

        }); 

        Schema::table('myjournal_entries_tags', function (Blueprint $table) {

            $table->foreign('tag_id')->references('id')->on('myjournal_tags');
            $table->foreign('entry_id')->references('id')->on('myjournal_entries');
            $table->foreign('user_id')->references('id')->on('users');


        });
        */

        /*
        Schema::create('myjournal_ratings', function (Blueprint $table) {

            $table->id();
            $table->timestamps();
            $table->integer('user_id');
            $table->integer('stars');
            $table->string('description', 30)->default('');

        });

        Schema::table('myjournal_ratings', function (Blueprint $table) {

            $table->foreign('user_id')->references('id')->on('users');

        });
        */

        /*
        Schema::table('myjournal_tags', function (Blueprint $table) {
            $table->string('name', 50);
        });
        */

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('myjournal_entries');
    }
}
