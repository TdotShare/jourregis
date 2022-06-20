<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\FileJour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class FileJourController extends Controller
{

    public function actionFileJourDelete($id)
    {
        $model = FileJour::find($id);

        if($model){

            if($model->file_profile_uid != session('username')){
                return $this->responseRedirectBack('คุณไม่ใช้เจ้าของข้อมูลนี้ คุณไม่มีสิทธิ์ลบไฟล์ของผู้อื่น !', 'warning');
            }

            if (is_file(public_path("upload/$model->file_path"))) {
                unlink(public_path("upload/$model->file_path"));
            }

            $model->delete();

            return $this->responseRedirectBack("ลบข้อมูลเรียบร้อย !");

        }else{
            return $this->responseRedirectBack('ไม่พบข้อมูลที่ต้องการค้นหา !', 'warning');
        }
    }

    protected function responseRedirectBack($message, $status = "success", $alert = true)
    {
        //primary , success , danger , warning
        return redirect()->back()->with(["message" => $message, "status" => $status, "alert" => $alert]);
    }

    protected function responseRedirectRoute($route, $message, $status = "success", $alert = true)
    {
        //primary , success , danger , warning
        return redirect()->route($route)->with(["message" => $message, "status" => $status, "alert" => $alert]);
    }


    protected function responseRequest($data, $bypass = true,  $status = "success")
    {
        return response()->json(['bypass' => $bypass,  'status' => $status, 'data' => $data], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header("Access-Control-Allow-Headers", "Authorization, Content-Type")
            ->header('Access-Control-Allow-Credentials', ' true');
    }
}