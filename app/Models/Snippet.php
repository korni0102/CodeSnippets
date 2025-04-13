<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @property int $id
 * @property string $description
 * @property string $row
 * @property int $crispdm
 * @property int|null $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Code> $codes
 * @property-read int|null $codes_count
 * @property-read \App\Models\RowCategory|null $rowCategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SnippetTag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet whereCrispdm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet whereRow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Snippet extends Model
{
    use HasFactory;

    public const TRANS_STRING_DESCRIPTION = 'trans.code.description.';

    private const CISPDM = [
        1 => 'Business Understanding',
        2 => 'Data Understanding',
        3 => 'Data preparation',
        4 => 'Modeling',
        5 => 'Evaluation',
        6 => 'Deployment',
    ];

    protected $fillable = [
        'description',
        'row',
        'crispdm',
        'category_id'
    ];

    public function rowCategory(): BelongsTo
    {
        return $this->belongsTo(RowCategory::class, 'category_id', 'id');
    }

    public function codes(): BelongsToMany
    {
        return $this->belongsToMany(
            Code::class,
            'codes_has_snippets',
            'snippet_id',
            'code_id'
        );
    }

    public function tags(): HasMany
    {
        return $this->hasMany(SnippetTag::class);
    }

    public static function getCrispdm(int $crispdmId): string
    {
        return __(self::CISPDM[$crispdmId]) ?? __("trans.Unknown crispdm");
    }

    public static function getAllCrispdm(): array
    {
        return self::CISPDM;
    }
}
