<?php

namespace App\Models;

use Auth;
use Date;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Global scope get all checkup where has relation with existing doctor & patient
        static::addGlobalScope('doctor', function (Builder $builder) {
            $builder->whereHas('doctor')->whereHas('patient');
        });

        // Auto assign line number on create new checkup
        static::creating( function($checkup) {
            $checkup->number = $checkup->generateNumber($checkup);
        });

        // Auto assign line number on update checkup
        static::updating( function($checkup) {
            $checkup->number = $checkup->generateNumber($checkup);
        });

        // Auto assign line number on saving checkup
        static::saving( function($checkup) {
            $checkup->number = $checkup->generateNumber($checkup);
        });
    }

    /**
     * Generate line number by check last checkup line number
     *
     * @return int
     */
    public function generateNumber($checkup)
    {
        $number = 1;
        // Get previous data of this checkup
        $prevData = Checkup::where('schedule_id', $checkup->schedule_id)
                        ->whereDate('date', $checkup->date)
                        ->find($checkup->id);

        if ( $prevData ) {
            // Keep number if schedule id not change
            $number = $prevData->number;
        } else {
            // Get new number by last checkup entry
            $lastNumber = Checkup::where('schedule_id', $checkup->schedule_id)
                                ->whereDate('date', $checkup->date)
                                ->max('number');

            if ( $lastNumber ) $number = $lastNumber + 1;
        }

        return $number;
    }

    /**
     * Relationship to Schedule - many to 1
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Relationship to Patient - many to 1
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relationship to Doctor - many to 1
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Relationship to User - many to 1
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get date in human readable format
     *
     * @return string
     */
    public function getFormattedDateAttribute()
    {
        return Date::parse($this->attributes['date'])->format('l, d F Y');
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
        $now = Carbon::parse('12 October 2020 14:00:01');
        $checkupDate = Carbon::parse($this->date . ' ' . $this->time_end);

        // Set is_done if date passed 1 day
        if ( $now->diffInSeconds($checkupDate, false) < 0 ) {
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
        $lineDigit = 3;

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
        // $time_start = Carbon::parse($this->time_start)->format('h:i A');
        // $time_end = Carbon::parse($this->time_end)->format('h:i A');
        $time_start = Carbon::parse($this->time_start)->format('H:i');
        $time_end = Carbon::parse($this->time_end)->format('H:i');

        return "{$time_start} - {$time_end}";
    }

    /**
     * Check if this checkup is enable for do the following action
     *
     * @return boolean
     */
    public function enable($action)
    {
        $result = true;
        $user = Auth::User();

        // Check if checkup datetime is passed today
        $now = Carbon::now();
        $checkupDate = Carbon::parse($this->date . ' ' . $this->time_end);
        $isPassed = ( $now->diffInSeconds($checkupDate, false) < 0 );

        switch ($action) {

            case 'edit' :
                // Unless superadmin always can edit forever
                if ( ! $user->isRole('superadmin') ) {
                    // Cannot edit after checkup is done
                    if ( ! $this->is_done )
                        $result = false;
                    // Cannot edit if checkup is cancelled
                    if ( $this->trashed() )
                        $result = false;
                    // Doctor cannot edit
                    if ( $user->isRole('doctor') )
                        $result = false;
                }
                break;

            case 'done' :
                // Cannot set done if checkup already done
                if ( $this->is_done )
                    $result = false;
                // Cannot set done if checkup is cancelled
                if ( $this->trashed() )
                    $result = false;
                break;

            case 'cancel' :
                // Cannot cancel if checkup already done
                if ( $this->is_done )
                    $result = false;
                // Cannot cancel if checkup already cancelled
                if ( $this->trashed() )
                    $result = false;
                break;

            case 'undone' :
                // Unable undo done if checkup status is not done
                if ( ! $this->is_done )
                    $result = false;
                // Cannot set done if checkup is cancelled
                if ( $this->trashed() )
                    $result = false;
                // Unable undo done if checkup date passed
                if ( $isPassed )
                    $result = false;
                break;

            case 'restore' :
                // Cannot undo cancel if checkup status is not deleted
                if ( ! $this->trashed() )
                    $result = false;
                // Cannot undo cancel if checkup date passed
                if ( $isPassed )
                    $result = false;
                break;

            case 'delete' :
                // Only can permanent delete if checkup status is cancelled
                if ( ! $this->trashed() )
                    $result = false;
                // Only superadmin can permanent delete
                if ( ! $user->isRole('superadmin') )
                    $result = false;
                break;

            case 'diagnosis' :
                // Cannot input diagnosis if checkup is cancelled
                if ( $this->trashed() )
                    $result = false;
                // Current login user role should doctor & has same doctor_id with checkup data
                if ( ! $user->isRole('doctor') ) {
                    $result = false;
                } else if ( $user->doctor->id != $this->doctor_id ) {
                    $result = false;
                }
                // Still can input diagnosis only if value is empty after checkup is done
                if ( $this->is_done && $this->doctor_note )
                    $result = false;
                break;

            default : break;
        }

        return $result;
    }
}
