<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ResetPassword extends Model
{
    use Notifiable;
    protected $table = 'password_resets';
    protected $timestamps = true;
}
