<?php
/**
 * Created by PhpStorm.
 * User: tomaskazatel
 * Date: 22.01.17
 * Time: 15:30
 */

namespace Barcamp\Talks\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePartnersTable extends Migration
{

    public function up()
    {
        Schema::create('barcamp_partners_partners', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();

            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('barcamp_partners_categories');

            $table->string('name', 300);
            $table->string('slug', 300)->nullable();
            $table->string('url', 300)->nullable();
            $table->boolean('enabled')->default(true);
            $table->smallInteger('sort_order')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down()
    {
        Schema::dropIfExists('barcamp_partners_partners');
    }

}