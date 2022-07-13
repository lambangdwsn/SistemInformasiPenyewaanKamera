<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email','NIP', 'username', 'password','alamat','role','email_verfied_at','no_tlp'
    ];

    protected $hidden = ['password'];
    //$ php artisan make:notification AmindResetPasswordNotification
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AmindResetPasswordNotification($token));
    }
}
