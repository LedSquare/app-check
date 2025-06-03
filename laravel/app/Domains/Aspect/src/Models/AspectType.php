<?php

namespace Aspect\Models;

use Aspect\Models\Stages\Step;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property \Illuminate\Support\Collection|Step[]|Step $steps
 */
class AspectType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'a_types';

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $casts = [
        //
    ];

    public function aspect(): BelongsTo
    {
        return $this->belongsTo(Aspect::class, 'type_id');
    }

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class, 'a_type_id');
    }
}
