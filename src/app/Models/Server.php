<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'servers';

    protected $fillable = [
        'base_uri',
        'name',
    ];

    public function casts(): array
    {
        return [
            'base_uri' => 'string',
            'name' => 'string',
        ];
    }
}
