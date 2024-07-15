<?php

namespace App\Admin\Database;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class Administrator extends Authenticatable
{
    use Notifiable, AdminBuilder, ModelTree;

    protected $fillable = ['username', 'password', 'name', 'email'];

    protected $hidden = ['password', 'remember_token'];
}
