<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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

    public function actionParticipant($id)
    {
        $model = Topic::find($id);

        if($model){
            return view("$this->page.participant", ['model' => $model]);
        }else{
            return $this->responseRedirectBack('ไม่พบข้อมูลที่ต้องการค้นหา !', 'warning');
        }
    }

    public function actionDelete($id)
    {
        $model = Topic::find($id);
        if($model){

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
