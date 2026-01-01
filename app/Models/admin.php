<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable {
    use HasFactory;

    protected $primaryKey = 'id_login';
    protected $fillable = ['nama', 'password', 'status_aktif', 'terakhir_login'];
    
    protected $hidden = [
        'password',
    ];
    
    // Disable remember token since admins table doesn't have it
    public function getRememberTokenName()
    {
        return null;
    }
}