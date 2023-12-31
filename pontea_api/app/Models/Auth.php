<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    use HasFactory;

    protected $table = 'auths';

    protected $fillable = [
        'user_id',
        'token',
        'deleted_at'
    ];
}
