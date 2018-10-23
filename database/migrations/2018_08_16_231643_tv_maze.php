<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TvMaze extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tv_maze', function (Blueprint $table) {
            $table->text('url')->nullable();
            $table->text('name')->nullable();
            $table->text('type')->nullable();
            $table->text('language')->nullable();
            $table->text('genres')->nullable();
            $table->text('status')->nullable();
            $table->unsignedInteger('runtime')->nullable();
            $table->text('officialSite')->nullable();
            $table->text('schedule')->nullable();
            $table->text('rating')->nullable();
            $table->unsignedInteger('weight')->nullable();
            $table->text('network')->nullable();
            $table->text('webChannel')->nullable();
            $table->text('externals')->nullable();
            $table->text('image')->nullable();
            $table->text('summary')->nullable();
            $table->unsignedInteger('updated')->nullable();
            $table->text('_links')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tv_maze');
    }
}
