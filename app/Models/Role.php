<?php

namespace App\Models;

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
        return $this->hasMany(User::class);
    }

    /**
     * Check if role is delete able
     * Undeletable Role : superadmin, doctor
     *
     * @return boolean
     */
    public function isDeletable()
    {
        $protectedRoles = ['superadmin', 'owner', 'doctor'];

        return ( ! in_array($this->slug, $protectedRoles) );
    }
}
