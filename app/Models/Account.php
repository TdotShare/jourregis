<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'jourregis_user';
    protected $primaryKey = 'user_id';

    //public $incrementing = false;

    protected $fillable = [
        "user_id", "user_uid", "user_card_id", "user_prename", "user_firstname_th", "user_lastname_th", "user_firstname_en", "user_lastname_en", "user_department", "user_faculty", "user_position", "user_campus", "user_email", "user_create_at", "user_update_at"
    ];

    // protected $hidden = [
    //     'pass_member',
    // ];

    protected $keyType = 'int';
    public $timestamps = false;
}