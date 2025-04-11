<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $code_category_id
 * @property int $approved
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\CodeCategory|null $codeCategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Snippet> $snippets
 * @property-read int|null $snippets_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Code newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Code newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Code query()
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereCodeCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Code withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Code withoutTrashed()
 * @mixin \Eloquent
 */
class Code extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TRANS_STRING_NAME = 'trans.code.name.';
    public const TRANS_STRING_DESCRIPTION = 'trans.code.description.';

    protected $fillable = [
        'user_id',
        'code_category_id',
        'approved',
        'name',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function codeCategory(): BelongsTo
    {
        return $this->belongsTo(CodeCategory::class);
    }

    public function snippets(): BelongsToMany
    {
        return $this->belongsToMany(
            Snippet::class,
            'codes_has_snippets',
            'code_id',
            'snippet_id'
        );
    }
}
