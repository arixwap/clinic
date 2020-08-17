<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
     * New Appended Attribute
     */
    protected $appends = [
        'time_range'
    ];

    /**
     * Relationship many to 1 - tabel `schedules` ke tabel `doctors`
     */
    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
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
