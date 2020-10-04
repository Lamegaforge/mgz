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
            $table->unsignedBigInteger('card_id');
            $table->string('slug');
            $table->string('title')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('url')->unique();
            $table->boolean('active')->default(false);
            $table->unsignedBigInteger('views')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clips');
    }
}
