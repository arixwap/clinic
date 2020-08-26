<?php

namespace App;

use Date;
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
        'name',
        'birthplace',
        'birthdate',
        'address',
        'phone',
        'gender',
    ];

    /**
     * Appended Attribute
     *
     * @var array
     */
    protected $appends = [
        'formatted_birthdate',
    ];

    /**
     * Relationship to Checkup - 1 to many
     */
    public function checkups()
    {
        return $this->hasMany('App\Checkup');
    }

    /**
     * Get birthdate in human readable format
     *
     * @return string
     */
    public function getFormattedBirthdateAttribute()
    {
        return Date::parse($this->attributes['birthdate'])->format('d F Y');
    }
}
