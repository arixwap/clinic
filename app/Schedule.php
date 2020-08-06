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
        'weekday',
        'time_start',
        'time_end',
        'limit',
        'off',
    ];

    /**
     * Relationship many to 1 - tabel `schedules` ke tabel `doctors`
     */
    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }
}
