<?php namespace Barcamp\Talks\Models;

use Model;
use October\Rain\Database\Traits\SoftDelete as SoftDeleteTrait;
use October\Rain\Database\Traits\Validation as ValidationTrait;
use Request;
use Str;

/**
 * Talk Model
 */
class Talk extends Model
{
    use SoftDeleteTrait;

    use ValidationTrait;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'barcamp_talks_talks';

    /**
     * @var array Model rules.
     */
    public $rules = [
        'name' => 'required|min:10',
        'hash' => 'unique:barcamp_talks_talks',
        'approved' => 'boolean',
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'user_id', 'category_id', 'name', 'annotation', 'note',
    ];

    /**
     * @var array Datetime fields.
     */
    public $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Before create reservation.
     */
    public function beforeCreate()
    {
        $this->hash = $this->getUniqueHash($this->name);
        $this->ip = Request::server('REMOTE_ADDR');
        $this->ip_forwarded = Request::server('HTTP_X_FORWARDED_FOR');
        $this->user_agent = Request::server('HTTP_USER_AGENT');
    }

    /**
     * Fetch only approved talks.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeIsApproved($query)
    {
        return $query->where('approved', true);
    }

    /**
     * Generate unique number for each talk. So you can reference particular talk by hash instead of internal ID.
     *
     * @param string $name
     *
     * @return string|null
     */
    public function getUniqueHash($name)
    {
        return substr(md5($name . Str::random(8)), 0, 24);
    }
}
