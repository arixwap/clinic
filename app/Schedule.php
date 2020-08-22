<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'weekday',
        'time_start',
        'time_end',
        'limit',
        'off',
    ];

    /**
     * Appended Attribute
     *
     * @var array
     */
    protected $appends = [
        'time_range'
    ];

    /**
     * Relationship to Doctor - many to 1
     */
    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }

    /**
     * Relationship to Checkup - 1 to many
     */
    public function checkups()
    {
        return $this->hasMany('App\Checkup');
    }

    /**
     * Create attribute Time Range by time_start and time_end.
     * Example result: 07:00 PM - 09:00 PM
     *
     * @return string
     */
    public function getTimeRangeAttribute()
    {
        $time_start = Carbon::parse($this->time_start)->format('h:i A');
        $time_end = Carbon::parse($this->time_end)->format('h:i A');

        return "{$time_start} - {$time_end}";
    }
}
