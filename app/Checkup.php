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
        'formatted_date',
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
     * Get date in human readable format
     *
     * @return string
     */
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->attributes['date'])->format('l, d F Y');
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

    /**
     * Get checkup status
     *
     * @return boolean
     */
    public function isStatus($type)
    {
        // Check if checkup datetime is passed today
        $now = Carbon::now();
        $checkupDate = Carbon::parse($this->date . ' ' . $this->time_end);
        $isPassed = ( $now->diffInDays($checkupDate, false) < 0 );

        switch($type) {
            case 'incoming':
                // Incoming fresh checkup with no cancelation
                $result = ( $this->is_done == 0 && ! $this->trashed() );
                break;
            case 'done-undoable':
                // Checkup is done, but can be undo before checkup time passed
                $result = ( $this->is_done == 1 && ! $isPassed && ! $this->trashed() );
                break;
            case 'done':
                // Checkup is done yet
                $result = ( $this->is_done == 1 && ! $this->trashed() );
                break;
            case 'cancel-undoable':
                // Canceled checkup, but can be undo before checkup time passed
                $result = ( $this->trashed() && ! $isPassed );
                break;
            case 'cancel':
                // Fixed canceled checkup
                $result = $this->trashed();
                break;
            default:
                $result = false;
                break;
        }

        return $result;
    }
}
