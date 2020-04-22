<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'username',
        'password',
        'address',
        'phone',
        'gender',
    ];
}
