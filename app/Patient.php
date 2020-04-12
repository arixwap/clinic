<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'birthplace',
        'birthdate',
        'address',
        'phone',
        'gender',
        'patient_type'
    ];
}
