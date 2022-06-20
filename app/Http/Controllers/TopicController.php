<?php

namespace App\Http\Controllers;

use App\Exports\ParticipantExport;
use App\Models\FileJour;
use App\Models\Profile;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Maatwebsite\Excel\Facades\Excel;

class TopicController extends Controller
{

    protected $page = "screen.admin.topic";
    protected $name = "หัวข้อการอบรม";


    public function actionIndex()
    {
        $model = Topic::all();
        return view("$this->page.index", ['model' => $model]);
    }

    public function actionCreate(Request $request)
    {
        if ($request->isMethod('get')) {
            return view("$this->page.create");
        }

        if($request->topic_enddate == null){
            return $this->responseRedirectBack('กรุณาเลือกวันที่ปิดรับสมัคร !', 'warning');
        }

        //return $request->all();

        $data = $request->all();
        $data['topic_create_by'] = session('username');
        $data['topic_update_by'] = session('username');
        $data['topic_status'] = 0;

        try {
            Topic::create($data);
            return $this->responseRedirectRoute('topic_ad_index_page' , 'สร้างข้อมูลเรียบร้อย !');
        } catch (\PDOException $th) {
            //return $th->getMessage();
            return $this->responseRedirectBack('ไม่สามารถสร้างข้อมูลได้ กรุณาลองใหม่อีกครั้ง !' , 'danger');
        }


        
    }

    public function actionUpdate($id = null, Request $request)
    {
        if ($request->isMethod('get')) {
            if ($model = Topic::find($id)) {
                return view("$this->page.update", ['model' => $model]);
            } else {
                return $this->responseRedirectBack('ไม่พบข้อมูลที่คุณค้นหา !', 'warning');
            }
        }


        $model = Topic::find($request->topic_id);

        try {
            if ($model) {

                $data = $request->all();
                $data['topic_update_by'] = session('username');

                $model->update($data);

                return $this->responseRedirectBack('แก้ไขข้อมูลเรียบร้อย !');

            } else {
                return $this->responseRedirectBack('ไม่พบข้อมูลที่ต้องการแก้ไข !', 'warning');
            }
        } catch (\PDOException $th) {
            return $this->responseRedirectBack('ไม่พบข้อมูลที่ต้องการค้นหา !', 'danger');
        }
    }

    public function actionGenerateExcel($id)
    {
        return Excel::download(new ParticipantExport($id) , 'ผู้สมัครเข้าร่วมอบรม' . date("d-m-Y")  .'.xlsx');
    }

    public function actionParticipant($id)
    {
        $model = Topic::find($id);

        if($model){

            //$participant = Profile::where('profile_topic_id' , $id)->get();

            $participant =  Profile::leftJoin('jourregis_user', 'jourregis_user.user_uid', '=', 'jourregis_profile.profile_user_uid')
            ->where('profile_topic_id' , $id)
            ->select(
                'jourregis_user.user_uid',
                'jourregis_user.user_prename',
                'jourregis_user.user_firstname_th',
                'jourregis_user.user_lastname_th',
                'jourregis_user.user_campus',
                'jourregis_profile.*'
            )->get();


            return view("$this->page.participant", 
            [
                'model' => $model,
                'participant' => $participant
            ]);
        }else{
            return $this->responseRedirectBack('ไม่พบข้อมูลที่ต้องการค้นหา !', 'warning');
        }
    }

    public function actionDelete($id)
    {
        $model = Topic::find($id);
        if($model){

            if (file_exists("upload/$model->topic_id")) {
                $this->actionDeleteFolderAll("upload/$model->topic_id");
            }

            FileJour::where('file_topic_id', $model->topic_id)->delete();
            Profile::where('profile_topic_id', $model->topic_id)->delete();

            $model->delete();

            return $this->responseRedirectBack("ลบข้อมูลเรียบร้อย !");

        }else{
            return $this->responseRedirectBack('ไม่พบข้อมูลที่ต้องการค้นหา !', 'warning');
        }
    }

    public function actionStatus($id)
    {
        $model = Topic::find($id);
        if($model){

            $model->topic_status = $model->topic_status === 0 ? 1 : 0;
            $model->save();

            return $this->responseRedirectBack("เปลี่ยนสถานะการใช้งาน เรียบร้อย !");

        }else{
            return $this->responseRedirectBack('ไม่พบข้อมูลที่ต้องการค้นหา !', 'warning');
        }
    }

    public function actionDeleteFolderAll($dir)
    {
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file))
                $this->actionDeleteFolderAll($file);
            else
                unlink($file);
        }
        rmdir($dir);
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
