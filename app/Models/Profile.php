<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'jourregis_profile';
    protected $primaryKey = 'profile_id';

    //public $incrementing = false;

    protected $fillable = [
        "profile_id", "profile_topic_id", "profile_position", "profile_affiliation", "profile_tel", "profile_email", "profile_create_at", "profile_update_at"
    ];

    // protected $hidden = [
    //     'pass_member',
    // ];

    protected $keyType = 'int';
    public $timestamps = false;
}