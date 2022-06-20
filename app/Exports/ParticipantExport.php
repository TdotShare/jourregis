<?php

namespace App\Exports;

use App\Models\Profile;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;



class ParticipantExport implements FromView , ShouldAutoSize
{

    protected $topic_id;

    function __construct($id)
    {
        $this->topic_id = $id;
    }


    public function view(): View
    {
        $participant =  Profile::leftJoin('jourregis_user', 'jourregis_user.user_uid', '=', 'jourregis_profile.profile_user_uid')
        ->where('profile_topic_id' , $this->topic_id)
        ->select(
            'jourregis_user.user_uid',
            'jourregis_user.user_prename',
            'jourregis_user.user_firstname_th',
            'jourregis_user.user_lastname_th',
            'jourregis_user.user_firstname_en',
            'jourregis_user.user_lastname_en',
            'jourregis_user.user_campus',
            'jourregis_profile.*'
        )->get();

        return view('screen.admin.topic.excel_resgis', [
            'model' => $participant
        ]);


    }


}