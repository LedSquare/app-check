<?php

namespace Aspect\Models\Stages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoodLevel extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'a_mood_levels';

    protected $fillable = [
        'procent',
    ];

    protected $casts = [
        'procent' => 'integer'
    ];
}
