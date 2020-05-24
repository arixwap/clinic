<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'week_day',
        'time_start',
        'time_end',
        'limit',
        'closes_date',
    ];

    /**
     * Relationship many to 1 - tabel `schedules` ke tabel `doctors`
     */
    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }
}
