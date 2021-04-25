<?php

namespace App\Models;

use Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'birthplace',
        'birthdate',
        'address',
        'phone',
        'gender',
    ];

    /**
     * Appended Attribute
     *
     * @var array
     */
    protected $appends = [
        'formatted_birthdate',
        'basic_info',
    ];

    /**
     * Relationship to Checkup - 1 to many
     */
    public function checkups()
    {
        return $this->hasMany(Checkup::class);
    }

    /**
     * Get patient number
     *
     * @return string
     */
    public function getNumberAttribute()
    {
        // Auto generate and save number if not exist
        if ( ! $this->attributes['number'] ) {

            $digit = 3;
            $numberDate = Date::parse($this->created_at)->format('Ymd');
            $numberPatient = Patient::where('number', 'LIKE', "%$numberDate%")->count() + 1;

            // Create number prefix digit. Exp : 001, 012
            $loop = $digit - intval( strlen($numberPatient) );
            $prefixNumberPatient = '';
            for ( $i = 1; $i <= $loop; $i++ ) {
                $prefixNumberPatient = $prefixNumberPatient . '0';
            }

            // Save patient ID Number
            $this->number = $numberDate . $prefixNumberPatient . $numberPatient;
            $this->save();
        }

        return $this->attributes['number'];
    }

    /**
     * Get birthdate in human readable format
     *
     * @return string
     */
    public function getFormattedBirthdateAttribute()
    {
        return Date::parse($this->attributes['birthdate'])->format('d F Y');
    }

    /**
     * Get patient basic information with format `$name ($gender) $ages`
     *
     * @return string
     */
    public function getBasicInfoAttribute()
    {
        $gender = [
            'Male' => __('M_gender'),
            'Female' => __('F_gender')
        ];
        $age = intval(date('Y')) - intval(date('Y', strtotime($this->birthdate)));

        return sprintf("%s (%s) %s", $this->name, $gender[$this->gender], $age.__('yr'));
    }
}
