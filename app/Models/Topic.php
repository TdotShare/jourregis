<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'jourregis_topic';
    protected $primaryKey = 'topic_id';

    //public $incrementing = false;

    protected $fillable = [
        "topic_id", "topic_title", "topic_note", "topic_enddate", "topic_status", "topic_create_by", "topic_update_by", "topic_create_at", "topic_update_at"
    ];

    // protected $hidden = [
    //     'pass_member',
    // ];

    protected $keyType = 'int';
    public $timestamps = false;
}