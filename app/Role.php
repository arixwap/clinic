<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Appended Attribute
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Relationship to User - 1 to many
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Check if role is delete able
     * Undeletable Role : superadmin, doctor
     *
     * @return boolean
     */
    public function isDeletable()
    {
        $protectedRoles = ['superadmin', 'doctor'];

        return ( ! in_array($this->slug, $protectedRoles) );
    }
}
