<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const ITEMS_PER_PAGE = 10;
    // roles
    const ADMIN = 1;
    const DRIVER = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function hasRole($role) {
        if (is_string($role)) {
            if (strtolower($role) === 'admin' || $role === self::getRoles()[self::ADMIN]) {
                $role = self::ADMIN;
            } else if (strtolower($role) === 'driver' || $role === self::getRoles()[self:: DRIVER]) {
                $role = self::DRIVER;
            }
        }
        if (is_integer($role)) {
            return $role === $this->role;
        }
        return false;
    }

    public function roleFormat() {
        return self::getRoles()[$this->role];
    }

    public static function getRoles()
    {
        return [
            self::ADMIN => 'Administrador',
            self::DRIVER => 'Conductor',
        ];
    }
}
