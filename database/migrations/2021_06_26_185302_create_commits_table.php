<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repo_id')->constrained('repos');
            $table->foreignId('author_id')->constrained('authors');
            $table->string('sha');
            $table->timestamp('date');
            $table->jsonb('author_data');
            $table->string('message');
            $table->jsonb('tree');
            $table->string('url');
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
        Schema::dropIfExists('commits');
    }
}
