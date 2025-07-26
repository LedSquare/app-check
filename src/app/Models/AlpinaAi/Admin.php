<?php

namespace App\Models\AlpinaAi;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $email
 * @property string $password
 * @property string $token
 */
class Admin extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'email',
        'password',
        'token',
    ];
}
