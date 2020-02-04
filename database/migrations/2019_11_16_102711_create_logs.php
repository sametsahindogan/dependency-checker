<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('model');
            $table->integer('model_id');
            $table->longText('old_value')->comment('json')->nullable();
            $table->longText('new_value')->comment('json')->nullable();
            $table->enum('action', ['created', 'updated', 'deleted', 'downloaded', 'reminded']);

            $table->timestamps();

        });

        Schema::table('logs', function(Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
