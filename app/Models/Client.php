<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasFactory,HasApiTokens, HasFactory, Notifiable;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'email',
        'password',
        'forget_password_token',
        'email_verify_token',
    ];
}
