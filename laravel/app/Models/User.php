<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Aspect\Models\Aspect;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
/**
 * @property integer $id
 * @property string $name $name
 * @property string $name $email
 * @property string $name $gender
 * @property string $name $phone
 *
 * @property \Illuminate\Database\Eloquent\Collection<Aspect> $aspects
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'firstname',
        'lastname',
        'fathername',
        'email',
        'password',
        'gender',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function aspects(): HasMany
    {
        return $this->hasMany(Aspect::class, 'user_id');
    }
}
