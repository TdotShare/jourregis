<?php

namespace App\Models;

class Admin
{
    //ช่วยดูแล
    protected $List = [
        "สถาบันวิจัยและพัฒนา"
    ];

    //เห็นปุ่ม delete
    protected $Super = [
        "jirayu.co"
    ];

    public function CheckedAuthenAdmin($faculty)
    {
        return in_array($faculty, $this->List);
    }

    public function CheckedAuthenSuper($uid)
    {
        return in_array($uid, $this->Super);
    }
}
