<?php

namespace App\Models;

use Auth;
use Date;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'birthplace',
        'birthdate',
        'address',
        'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Relationship to Role - many to 1
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relationship to Doctor - 1 to 1
     */
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    /**
     * Relationship to Checkup - 1 to many
     */
    public function checkups()
    {
        return $this->hasMany(Checkup::class);
    }

    /**
     * Get created_at with selected format
     *
     * @return string
     */
    public function formatCreatedAt($format = "d F Y")
    {
        return Date::parse($this->attributes['created_at'])->format($format);
    }

    /**
     * Check user is current logged user
     *
     * @return boolean
     */
    public function isMine()
    {
        return ( Auth::id() == $this->id );
    }

    /**
     * Check user role
     *
     * @return boolean
     */
    public function isRole($role)
    {
        return ( $this->role->slug == $role ) || ( $this->role->name == $role );
    }
}
