<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $title
 * @property string $key
 * @property string $value
 * @property int $groups
 * @property int $type
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Setting onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereGroups($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Setting withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Setting withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting query()
 */
class Setting extends Model
{
    use SoftDeletes;

    public const GROUP_SYSTEM = 1;
    public const GROUP_CONTACT_FORM = 2;

    const ACTIVE_YES = 1;
    const ACTIVE_NO = 0;

    public const TYPE_STRING = 1;
    public const TYPE_TEXT = 2;
    public const TYPE_CHECKBOX = 3;
    public const TYPE_RADIO = 4;
    public const TYPE_SELECT = 5;
    public const TYPE_MULTI_SELECT = 6;

    /**
     * @var array
     */
    public static $groups = [
        self::GROUP_SYSTEM => 'setting.groups.system',
        self::GROUP_CONTACT_FORM => 'setting.groups.contact-form',
    ];

    /**
     * @param int $group
     * @return string
     */
    public static function getGroup($group)
    {
        return trans(self::$groups[$group]);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'key', 'value', 'groups', 'type', 'active',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
