<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;

/**
 * @property integer $id
 * @property integer $role_id
 * @property string $name
 * @property string $email
 * @property string $email_verified_at
 * @property string $remember_token
 * @property string $password
 * @property string $phone
 * @property string $memberof
 * @property string $created_at
 * @property string $updated_at
 * @property string $guid
 * @property string $domain
 * @property string $username
 * @property Comment $comment
 * @property GroupUser $groupUser
 * @property Ticket $ticket
 * @property Role $role
 */

class User extends Authenticatable implements LdapAuthenticatable
{
    use HasApiTokens, HasFactory, Notifiable, AuthenticatesWithLdap;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'email_verified_at', 'remember_token', 'password', 'phone', 'memberof', 'created_at', 'updated_at', 'guid', 'domain', 'username'];

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
    ];

}
