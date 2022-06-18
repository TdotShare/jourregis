<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileJour extends Model
{
    protected $table = 'jourregis_file';
    protected $primaryKey = 'file_id';

    //public $incrementing = false;

    protected $fillable = [
        "file_id", "file_profile_id" , "file_topic_id", "file_name", "file_path", "file_create_at", "file_update_at"
    ];

    // protected $hidden = [
    //     'pass_member',
    // ];

    protected $keyType = 'int';
    public $timestamps = false;
}