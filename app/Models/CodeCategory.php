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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Code> $codes
 * @property-read int|null $codes_count
 * @method static \Illuminate\Database\Eloquent\Builder|CodeCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CodeCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CodeCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CodeCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CodeCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CodeCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CodeCategory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CodeCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CodeCategory extends Model
{
    use HasFactory;

    const TYPES = [
        1 => 'Neural Network',
        2 => 'Natural Language Processing',
        3 => 'Machine Learning',
    ];

    protected $fillable = [
        'type'
    ];

    public function codes(): HasMany
    {
        return $this->hasMany(Code::class);
    }

    public static function getType(int $typeId): string
    {
        return __(self::TYPES[$typeId]) ?? __("trans.Unknown type");
    }

    public static function getTypes(): array
    {
        return self::TYPES;
    }
}
