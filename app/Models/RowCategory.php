<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @property int $id
 * @property int $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Snippet> $snippets
 * @property-read int|null $snippets_count
 * @method static \Illuminate\Database\Eloquent\Builder|RowCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RowCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RowCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|RowCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowCategory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RowCategory extends Model
{
    use HasFactory;

    public const TRANS_STRING = 'trans.row.category.';

    protected $fillable = [
        'type'
    ];

    public static function getAllCategoriesForSelect(): array
    {
        return RowCategory::pluck('type', 'id')->toArray();
    }

    public function snippets(): HasMany
    {
        return $this->hasMany(Snippet::class);
    }
}
