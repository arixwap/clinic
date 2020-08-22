<?php

namespace App;

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
        'full_name',
        'gender',
        'birthplace',
        'birthdate',
        'address',
        'phone',
        'university',
        'qualification',
        'str',
        'str_start_date',
        'str_end_date',
        'polyclinic',
        'photo_url',
    ];

    /**
     * Relationship to User - 1 to 1
     * 'App\User'   => Eloquent Filename
     * 'id'         => foreign_key id for relationship  -> table users.id
     * 'user_id'    => local_key id for relationship    -> table doctors.user_id
     */
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * Relationship to Schedule - 1 to many
     */
    public function schedules()
    {
        return $this->hasMany('App\Schedule');
    }

    /**
     * Relationship to Checkup - 1 to many
     */
    public function checkups()
    {
        return $this->hasMany('App\Checkup');
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
