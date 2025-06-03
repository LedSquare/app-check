<?php

namespace Aspect\Models\Stages\Shape;

use Aspect\Models\Stages\Shape\Shape;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShapeCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'a_shape_categories';

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $casts = [

    ];
    public function shapes(): HasMany
    {
        return $this->hasMany(Shape::class, 'a_shape_category_id');
    }
}
