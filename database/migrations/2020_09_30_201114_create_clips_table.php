<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tracking_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('card_id')->nullable();
            $table->string('slug');
            $table->string('title')->nullable();
            $table->string('game')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('url')->unique();
            $table->boolean('active')->default(false);
            $table->enum('state', ['active', 'waiting', 'rejected'])->default('waiting');
            $table->unsignedBigInteger('views')->nullable();
            $table->float('duration')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index('slug');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('card_id')->references('id')->on('cards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('clips');
        Schema::enableForeignKeyConstraints();
    }
}
