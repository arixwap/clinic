<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

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
    ];

    /**
     * Relationship to Checkup - 1 to many
     */
    public function checkups()
    {
        return $this->hasMany('App\Checkup');
    }
}
