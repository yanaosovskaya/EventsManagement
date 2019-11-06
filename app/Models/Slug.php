<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Slug
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Snippet[] $snippets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slug whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slug whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slug query()
 */
class Slug extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The slug that belong to the snippet.
     */
    public function snippets()
    {
        return $this->belongsToMany(Snippet::class, 'snippet_slug');
    }
}
