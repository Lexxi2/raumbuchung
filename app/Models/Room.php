<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $color
 * @property string $location
 * @property string $description
 */
class Room extends Model
{
    use HasFactory;
    
    /**
     * @var array
     */
    protected $fillable = ['name', 'username', 'email', 'password', 'color', 'location', 'description'];
    // Fillable Attributes

}
