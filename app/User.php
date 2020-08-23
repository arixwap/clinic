<?php

namespace App;

use Auth;
use Date;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
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
     * Appended Attribute
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Relationship to Role - many to 1
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    /**
     * Relationship to Doctor - 1 to 1
     */
    public function doctor()
    {
        return $this->hasOne('App\Doctor');
    }

    /**
     * Relationship to Checkup - 1 to many
     */
    public function checkups()
    {
        return $this->hasMany('App\Checkup');
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
