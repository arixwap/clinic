<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkup extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schedule_id',
        'patient_id',
        'doctor_id',
        'user_id',
        'number',
        'date',
        'time_start',
        'time_end',
        'bpjs',
        'description',
        'doctor_note',
        'new_patient',
        'is_done',
    ];

    /**
     * Appended Attribute
     *
     * @var array
     */
    protected $appends = [
        'time_range',
        'line_number',
    ];

    /**
     * Relationship to Schedule - many to 1
     */
    public function schedule()
    {
        return $this->belongsTo('App\Schedule');
    }

    /**
     * Relationship to Patient - many to 1
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }

    /**
     * Relationship to Doctor - many to 1
     */
    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }

    /**
     * Relationship to User - many to 1
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get checkup is_done
     * if date checkup is passed, set checkup is_done = 1
     *
     * @return boolean
     */
    public function getIsDoneAttribute()
    {
        $now = Carbon::now();
        $checkupDate = $this->date;

        // Set is_done if date passed 1 day
        if ( $now->diffInDays($checkupDate, false) < 0 ) {
            $this->is_done = 1;
            $this->save();
        }

        return $this->attributes['is_done'];
    }

    /**
     * Create attribute Line Number by format attribute number
     * Example : 1 to 0001
     *
     * @return string
     */
    public function getLineNumberAttribute()
    {
        $lineDigit = 4;

        $loop = $lineDigit - intval( strlen($this->number) );
        $prefix = '';
        for ( $i = 1; $i <= $loop; $i++ ) {
            $prefix = $prefix . '0';
        }

        return $prefix . $this->number;
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
