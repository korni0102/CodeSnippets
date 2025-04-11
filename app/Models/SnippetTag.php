<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property string $tag_name
 * @property int $snippet_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Snippet> $snippets
 * @property-read int|null $snippets_count
 * @method static \Illuminate\Database\Eloquent\Builder|SnippetTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SnippetTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SnippetTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|SnippetTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SnippetTag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SnippetTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SnippetTag whereSnippetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SnippetTag whereTagName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SnippetTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SnippetTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_name',
        'snippet_id',
    ];

    public function snippets(): HasMany
    {
        return $this->hasMany(Snippet::class);
    }
}
