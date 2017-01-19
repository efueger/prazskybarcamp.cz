<?php namespace Barcamp\Talks\Models;

use Model;

/**
 * Vote Model
 */
class Vote extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'barcamp_talks_votes';

    /**
     * @var array Datetime fields.
     */
    public $dates = ['created_at', 'updated_at'];
}
