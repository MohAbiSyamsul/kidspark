<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'username', 'password', 'nama', 'jabatan', 'foto',
    ];

    protected $hidden = ['password'];
}
