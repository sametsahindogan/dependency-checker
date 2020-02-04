<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDependenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dependencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('repository_id');
            $table->string('title');
            $table->string('current_version');
            $table->string('latest_version')->nullable();
            $table->enum('status',['uptodate', 'outdated','checking']);
            $table->timestamps();
        });

        Schema::table('dependencies', function(Blueprint $table) {
            $table->foreign('type_id')
                ->references('id')
                ->on('dependency_types');

            $table->foreign('repository_id')
                ->references('id')
                ->on('repositories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dependencies');
    }
}
