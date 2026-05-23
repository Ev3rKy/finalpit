<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Staff extends Model
{
    protected $fillable = [
        'full_name', 'staff_id_code', 'email', 'password',
        'role', 'specialty', 'is_available',
    ];
 
    protected $hidden = ['password', 'remember_token'];
}
