<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Snippet
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property int $visible
 * @property int $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Snippet onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Snippet whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Snippet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Snippet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Snippet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Snippet whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Snippet whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Snippet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Snippet whereVisible($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Snippet withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Snippet withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Slug[] $slugs
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Snippet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Snippet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Snippet query()
 */
class Snippet extends Model
{
    use SoftDeletes;

    public const VISIBLE_NO = 0;
    public const VISIBLE_ALL_PAGES = 1;
    public const VISIBLE_ON_PAGES = 2;
    public const VISIBLE_NOT_PAGES = 3;

    public const LOCATION_HEADER = 1;
    public const LOCATION_FOOTER = 2;

    /**
     * @return array
     */
    public static function visibilityStatuses()
    {
        return [
            self::VISIBLE_NO => trans('snippet.visible.no'),
            self::VISIBLE_ALL_PAGES => trans('snippet.visible.all_pages'),
            self::VISIBLE_ON_PAGES => trans('snippet.visible.on_pages'),
            self::VISIBLE_NOT_PAGES => trans('snippet.visible.not_pages'),
        ];
    }

    /**
     * @param int $status
     * @return string
     */
    public static function getVisibilityStatus($status)
    {
        return static::visibilityStatuses()[$status];
    }

    /**
     * @return array
     */
    public static function locationStatuses()
    {
        return [
            self::LOCATION_HEADER => trans('snippet.location.header'),
            self::LOCATION_FOOTER => trans('snippet.location.footer'),
        ];
    }

    /**
     * @param int $status
     * @return string
     */
    public static function getLocationStatus($status)
    {
        return static::locationStatuses()[$status];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'content', 'visible', 'location',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The snippet that belong to the slug.
     */
    public function slugs()
    {
        return $this->belongsToMany(Slug::class, 'snippet_slug');
    }
}
