<?php

namespace Aspect\Models\Stages;

use Aspect\Models\AspectType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Morph Relation class
 */
class Step extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'a_steps';

    protected $fillable = [
        'name',
        'step_class_name',
        'a_type_id',
        'order',
    ];

    protected $casts = [
        'a_type_id' => 'integer',
        'order' => 'integer',
    ];

    public function aspectType(): BelongsTo
    {
        return $this->belongsTo(AspectType::class, 'a_type_id');
    }
}
