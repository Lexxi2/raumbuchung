<?php

namespace App\Ldap;

use LdapRecord\Models\FreeIPA\User;
use Illuminate\Contracts\Auth\Authenticatable;
use LdapRecord\Models\Concerns\CanAuthenticate;

class Admin extends User implements Authenticatable
{
    use CanAuthenticate;

    protected $guidKey = 'ipauniqueid';
    
    public static $objectClasses = [
        'top',
        'person',
        'inetorgperson',
        'organizationalperson',
    ];
}