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
        'number',
        'date',
        'time',
        'bpjs',
        'description',
        'doctor_note',
        'new_patient',
    ];

    /**
     * Relationship many to 1 - tabel 'checkups' ke tabel 'schedules'
     */
    public function schedule()
    {
        return $this->belongsTo('App\Schedule');
    }

    /**
     * Relationship many to 1 - tabel 'checkups' ke tabel 'patients'
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }

    /**
     * Relationship many to 1 - tabel 'checkups' ke tabel 'doctors'
     */
    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }

    /**
     * Relationship many to 1 - tabel 'checkups' ke tabel 'users'
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
