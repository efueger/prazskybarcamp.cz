<?php namespace Barcamp\Talks\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateVotesTable extends Migration
{
    public function up()
    {
        Schema::create('barcamp_talks_votes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('talk_id')->unsigned()->nullable();
            $table->foreign('talk_id')->references('id')->on('barcamp_talks_talks');

            $table->string('ip', 300)->nullable();
            $table->string('ip_forwarded', 300)->nullable();
            $table->string('user_agent', 300)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barcamp_talks_votes');
    }
}
