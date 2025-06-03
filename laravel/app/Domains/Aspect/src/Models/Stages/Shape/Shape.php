<?php

namespace Aspect\Models\Stages\Shape;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Shape extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'a_shapes';

    protected $fillable = [
        'a_shape_category_id',
        'filepath'
    ];

    protected $casts = [
        'a_shape_category_id' => 'integer',
    ];

    public function shapeCategory(): BelongsTo
    {
        return $this->belongsTo(ShapeCategory::class, 'a_shape_category_id');
    }

}
