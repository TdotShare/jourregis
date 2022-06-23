<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\FileJour;
use App\Models\Profile;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProfileController extends Controller
{

    public function actionStatus($id)
    {
        $model = Profile::find($id);
        if($model){

            $model->profile_status = $model->profile_status === 0 ? 1 : 0;
            $model->save();

            return $this->responseRedirectBack("เปลี่ยนสถานะการใช้งาน เรียบร้อย !");

        }else{
            return $this->responseRedirectBack('ไม่พบข้อมูลที่ต้องการค้นหา !', 'warning');
        }
    }



    public function actionSubmission($id)
    {
        $model = Profile::where('profile_user_uid', '=', session('username'))->where('profile_topic_id', '=', $id)->first();

        if ($model) {

            if($model->profile_steps != 3){
                return $this->responseRedirectBack('ขั้นตอนการดำเนินการไม่ถูกต้อง กรุณาติดต่อเจ้าหน้าที่ !', 'danger');
            }

            $model->profile_steps = 4;
            $model->save();

            return $this->responseRedirectRoute('home_index_page' , 'ลงทะเบียนเข้าร่วมโครงการเรียบร้อย หากผ่านการพิจารณาเจ้าหน้าที่จะติดต่อกลับผ่านทาง Email !');

        } else {
            return $this->responseRedirectBack('ไม่พบข้อมูลที่ต้องการค้นหา !', 'warning');
        }
    }

    public function actionBackSteps($id)
    {
        $model = Profile::where('profile_user_uid', '=', session('username'))->where('profile_topic_id', '=', $id)->first();

        if ($model) {

            $model->profile_steps = 1;
            $model->save();

            return $this->responseRedirectBack('ย้อนกลับไปยัง ข้อมูลทั่วไป เรียบร้อยกรุณาตรวจสอบข้อมูลของคุณอีกครั้ง !');

        } else {
            return $this->responseRedirectBack('ไม่พบข้อมูลที่ต้องการค้นหา !', 'warning');
        }
    }

    public function actionAttachment($id)
    {
        $model = Profile::where('profile_user_uid', '=', session('username'))->where('profile_topic_id', '=', $id)->first();

        if ($model) {

            if ($model->profile_steps != 2) {
                return $this->responseRedirectBack('ขั้นตอนการดำเนินการไม่ถูกต้อง กรุณาติดต่อเจ้าหน้าที่ !', 'danger');
            }

            $model->profile_steps = 3;
            $model->save();

            return $this->responseRedirectBack('บันทึกข้อมูล เอกสารแนบ เรียบร้อย !');
        } else {
            return $this->responseRedirectBack('ไม่พบข้อมูลที่ต้องการค้นหา !', 'warning');
        }
    }

    public function actionUpdate(Request $request)
    {

        $data = $request->all();

        $data['profile_steps'] = 2;
        $data['profile_user_uid'] = session("username");
        $data['profile_status'] = 0;


        $model = Profile::where('profile_user_uid', '=', session('username'))->where('profile_topic_id', '=', $request->profile_topic_id)->first();

        try {
            if ($model) {
                $model->update($data);
                return $this->responseRedirectBack('บันทึก ข้อมูลทั่วไป เรียบร้อย !');
            } else {

                Profile::create($data);
                return $this->responseRedirectBack('บันทึก ข้อมูลทั่วไป เรียบร้อย !');
            }
        } catch (\Throwable $th) {
            return $this->responseRedirectBack('บันทึก ข้อมูลทั่วไป ไม่สำเร็จ !', 'danger');
        }
    }

    public function actionUpload(Request $request)
    {

        $maxSize = 7242880;

        if (!$request->file('file_item')) {
            return $this->responseRedirectBack('กรุณาแนบไฟล์ !', 'warning');
        }

        if ($request->file('file_item')->getSize() > $maxSize) {
            return $this->responseRedirectBack('ไม่สามารถอัปโหลดไฟล์ที่มีขนาดไฟล์มากกว่า 7 mb ได้ !', 'warning');
        }

        $fileName =  $this->randomFileName() . '.' . $request->file('file_item')->getClientOriginalExtension();
        $folder_main =  $this->actionCreateFolder($request->file_topic_id, md5(session('username')));



        try {
            if ($request->file('file_item')->move(public_path("$folder_main"), $fileName)) {

                $data = [
                    'file_profile_uid' => session('username'),
                    'file_topic_id' => $request->file_topic_id,
                    'file_name' => $request->file_name,
                    'file_path' => $folder_main . "/" . $fileName,
                ];

                FileJour::create($data);

                return $this->responseRedirectBack('อัปโหลดไฟล์เรียบร้อย !');
            } else {
                return $this->responseRedirectBack('อัปโหลดไฟล์ไม่สำเร็จ กรุณาลองใหม่อีกครั้ง !', 'warning');
            }
        } catch (\Throwable $th) {
            return $this->responseRedirectBack('อัปโหลดไฟล์ไม่สำเร็จ กรุณาลองใหม่อีกครั้ง !', 'danger');
        }
    }

    function randomFileName($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function actionCreateFolder($topic_id, $username)
    {

        $destinationPath = public_path("upload/file/$topic_id/$username");
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $getName = "upload/file/$topic_id/$username";

        return $getName;
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
