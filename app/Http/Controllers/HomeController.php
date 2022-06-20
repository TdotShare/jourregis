<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\FileJour;
use App\Models\Profile;
use App\Models\Topic;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{

    protected $page = "screen.home";
    protected $name = "หัวข้อการอบรม";


    public function actionIndex()
    {
        foreach (Topic::where('topic_status', '=', 1)->get() as $key => $data) {

            $now = new DateTime("now");
            $PostQClose = new DateTime($data->topic_enddate);

            if ($PostQClose <= $now) {
                $data->topic_status = 0;
                $data->save();
            }
        }

        $model = Topic::where('topic_status', '=', 1)->get();

        return view("$this->page.index", ['model' => $model]);
    }

    public function actionView($id)
    {

        if(!session('auth')){
            return redirect()->route("login_page");
        }

        $model = Topic::find($id);

        if (!$model) {
            return $this->responseRedirectBack('ไม่พบข้อมูลที่ต้องการค้นหา !', 'warning');
        }

        if ($model->topic_status != 1) {
            return $this->responseRedirectBack('หัวข้อการอมรบที่เลือกปิดรับสมัครแล้ว !', 'warning');
        }


        $profile = Profile::where('profile_user_uid', '=', session('username'))->where('profile_topic_id', '=', $id)->first();
        $account = Account::where('user_uid', '=', session('username'))->first();
        $fileJour = FileJour::where('file_profile_uid', '=', session('username'))->where('file_topic_id', '=', $id)->get();

        if ($profile) {
            if ($profile->profile_steps == 4) {
                return $this->responseRedirectBack('ข้อมูลของคุณถูกส่งให้กับเจ้าหน้าที่เรียบร้อย !', 'warning');
            }
        }

        return view("$this->page.view", [
            'model' => $model,
            "profile" => $profile,
            'account' => $account,
            'fileJour' => $fileJour,
        ]);
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
