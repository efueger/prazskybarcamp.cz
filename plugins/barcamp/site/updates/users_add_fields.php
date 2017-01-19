<?php namespace Barcamp\Site\Updates;

use Illuminate\Support\Facades\DB;
use October\Rain\Database\Updates\Migration;
use Schema;

class UsersAddFields extends Migration
{
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('phone', 300)->nullable()->after('permissions');
            $table->string('link_facebook', 300)->nullable()->after('phone');
            $table->string('link_twitter', 300)->nullable()->after('link_facebook');
            $table->string('link_instagram', 300)->nullable()->after('link_twitter');
            $table->string('link_linkedin', 300)->nullable()->after('link_instagram');
            $table->string('link_web', 300)->nullable()->after('link_linkedin');
            $table->text('self_promo')->nullable()->after('link_web');
        });
    }

    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn([
                'phone',
                'link_facebook',
                'link_twitter',
                'link_instagram',
                'link_linkedin',
                'link_web',
                'self_promo',
            ]);
        });
    }
}
