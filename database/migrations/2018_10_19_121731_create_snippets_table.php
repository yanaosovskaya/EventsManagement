<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnippetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snippets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique();
            $table->text('content');
            $table->tinyInteger('visible')->default(1);
            $table->tinyInteger('location')->default(1);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('slugs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();

            $table->timestamps();
        });

        Schema::create('snippet_slug', function (Blueprint $table) {
            $table->integer('snippet_id')->unsigned();
            $table->integer('slug_id')->unsigned();

            $table->foreign('snippet_id')
                ->references('id')->on('snippets')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('slug_id')
                ->references('id')->on('slugs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('snippet_slug', function (Blueprint $table) {
            $table->dropForeign(['snippet_id',]);
            $table->dropForeign(['slug_id']);
        });

        Schema::dropIfExists('snippet_slug');
        Schema::dropIfExists('slugs');
        Schema::dropIfExists('snippets');
    }
}
