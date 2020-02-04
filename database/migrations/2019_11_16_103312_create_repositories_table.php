<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('type_id');
            $table->enum('status', ['uptodate', 'outdated', 'checking', 'error']);
            $table->string('repo_slug');
            $table->string('project_slug');
            $table->string('repo_url');
            $table->string('repo_id')->nullable();
            $table->timestamp('checked_at')->nullable();
            $table->timestamps();
        });
        Schema::table('repositories', function (Blueprint $table) {
            $table->unique(['repo_slug', 'project_slug']);

            $table->foreign('type_id')
                ->references('id')
                ->on('git_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repositories');
    }
}
