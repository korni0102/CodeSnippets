<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use App\Services\TranslationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Translation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation query()
 * @mixin \Eloquent
 */
class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'locale',
        'value',
    ];
}
