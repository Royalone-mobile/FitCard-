<?php

namespace App\Model;

/**
 * Created by PhpStorm.
 * User: Long
 * Date: 11/14/2015
 * Time: 10:33 PM
 */
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Admin extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    protected $table = 'admin';

    use Authenticatable,
        CanResetPassword;

    protected $fillable = ['name','password'];

    protected $hidden = ['password','remember_token'];
}
