<?php namespace Barcamp\Talks\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTalksTable extends Migration
{
    public function up()
    {
        Schema::create('barcamp_talks_talks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('barcamp_talks_categories');

            $table->integer('type_id')->unsigned()->nullable();
            $table->foreign('type_id')->references('id')->on('barcamp_talks_types');

            $table->string('name', 300);
            $table->string('hash', 32);
            $table->datetime('date')->nullable();
            $table->text('annotation')->nullable();
            $table->text('note')->nullable();
            $table->integer('votes')->default(0);
            $table->boolean('approved')->default(false);

            $table->string('ip', 300)->nullable();
            $table->string('ip_forwarded', 300)->nullable();
            $table->string('user_agent', 300)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barcamp_talks_talks');
    }
}
