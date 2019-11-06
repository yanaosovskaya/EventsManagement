<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Itmaster\Page\Models\Page;

/**
 * App\Models\MenuItem
 *
 * @property int $id
 * @property int $menu_id
 * @property int $parent_id
 * @property string $name
 * @property int $type
 * @property string $content
 * @property int $sorting
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuItem onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereSorting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuItem withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MenuItem[] $children
 * @property-read \App\Models\Menu $menu
 * @property-read \App\Models\MenuItem $parent
 * @property int $visible
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem query()
 */
class MenuItem extends Model
{
    use SoftDeletes;

    public const TYPE_LINK = 1;
    public const TYPE_TEXT = 2;
    public const TYPE_PAGE = 3;
    public const TYPE_CUSTOM_HTML = 4;

    public const VISIBLE_NO = 0;
    public const VISIBLE_YES = 1;
    public const VISIBLE_LOGGED = 2;
    public const VISIBLE_NOT_LOGGED = 3;

    /**
     * @var array
     */
    public static $types = [
        self::TYPE_LINK => 'menu.item.types.link',
        self::TYPE_TEXT => 'menu.item.types.text',
        self::TYPE_PAGE => 'menu.item.types.page',
        self::TYPE_CUSTOM_HTML => 'menu.item.types.custom_html',
    ];

    /**
     * @return array
     */
    public static function visibilityStatuses()
    {
        return [
            self::VISIBLE_YES => trans('menu.item.visible.yes'),
            self::VISIBLE_LOGGED => trans('menu.item.visible.only_logged'),
            self::VISIBLE_NOT_LOGGED => trans('menu.item.visible.only_not_logged'),
            self::VISIBLE_NO => trans('menu.item.visible.no'),
        ];
    }

    /**
     * @param int $type
     * @return string
     */
    public static function getType($type)
    {
        return trans(self::$types[$type]);
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'menu_id', 'parent_id', 'name', 'type', 'content', 'sorting', 'visible',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|null
     */
    public function page()
    {
        if ($this->type === self::TYPE_PAGE) {
            return $this->hasOne(Page::class, 'id', 'content');
        }

        return null;
    }
}
