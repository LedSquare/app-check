<?php

namespace App\Models\AlpinaAi;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'token',
        'email',
        'offer_id',
        'password',
    ];
}
