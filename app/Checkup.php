<?php

namespace App;

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
}
