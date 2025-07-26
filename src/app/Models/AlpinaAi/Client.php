<?php

namespace App\Models\AlpinaAi;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $uuid
 * @property string $token
 * @property string $email
 * @property string $offer_id
 * @property string $password
 */
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
