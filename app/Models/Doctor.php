<?php

namespace App\Models;

use Auth;
use Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'university',
        'qualification',
        'str',
        'str_start_date',
        'str_end_date',
        'polyclinic',
    ];

    /**
     * Appended Attribute
     *
     * @var array
     */
    protected $appends = [
        'name',
        'formatted_birthdate',
    ];

    /**
     * Relationship to User - 1 to 1
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Relationship to Schedule - 1 to many
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Relationship to Checkup - 1 to many
     */
    public function checkups()
    {
        return $this->hasMany(Checkup::class);
    }

    /**
     * Get doctor name from user relation
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->user->name;
    }

    /**
     * Get birthdate in human readable format
     *
     * @return string
     */
    public function getFormattedBirthdateAttribute()
    {
        return Date::parse($this->user->birthdate)->format('d F Y');
    }

    /**
     * Check if doctor is current logged user
     *
     * @return boolean
     */
    public function isMe()
    {
        return ( $this->user_id == Auth::id() );
    }

    /**
     * Get doctor name with suffix string if isMe() return true
     *
     * @return string
     */
    public function nameIsMe($suffix = null)
    {
        if ( $suffix == null ) $suffix = sprintf(' (%s)', __('Me'));

        return ( $this->isMe() ) ? $this->name.$suffix : $this->name;
    }

    /**
     * Return doctor schedule in weekday format
     */
    public function formatSchedules()
    {
        $offdates = array(); // ---------------------------------------WIP

        // Build schedule index by weekday
        $weekdays = [
            'mon' => ['off' => true, 'day' => __('Monday'), 'times' => array()],
            'tue' => ['off' => true, 'day' => __('Tuesday'), 'times' => array()],
            'wed' => ['off' => true, 'day' => __('Wednesday'), 'times' => array()],
            'thu' => ['off' => true, 'day' => __('Thursday'), 'times' => array()],
            'fri' => ['off' => true, 'day' => __('Friday'), 'times' => array()],
            'sat' => ['off' => true, 'day' => __('Saturday'), 'times' => array()],
            'sun' => ['off' => true, 'day' => __('Sunday'), 'times' => array()]
        ];

        // Push data into weekday array
        foreach ( $this->schedules as $schedule ) {
            $weekdays[$schedule->weekday]['off'] = $schedule->off;
            $weekdays[$schedule->weekday]['times'][] = $schedule;
        }

        return [
            'weekdays' => $weekdays,
            'offdates' => $offdates
        ];
    }
}
