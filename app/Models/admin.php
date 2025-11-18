<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model {
    use HasFactory;

    protected $primaryKey = 'id_login';
    protected $fillable = ['nama', 'password', 'status_aktif', 'terakhir_login'];
}