<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Account;
use App\Models\Admin;

class AuthenticationController extends Controller
{

    public function actionHomeLogin()
    {
        return view("auth.login");
    }

    public function actionHomeRMUTILogin()
    {
        if (!Cookie::get('OAUTH2_login_info')) {
            header("location: " . "https://mis-ird.rmuti.ac.th/sso/auth/login?url=" . route("login_rmuti_data"));
            exit(0);
        } else {
            return redirect()->route("login_rmuti_data");
        }
    }

    public function actionLoginRmuti(Request $request)
    {
        if (isset($_COOKIE['OAUTH2_login_info'])) {

            $data = json_decode($_COOKIE['OAUTH2_login_info']);

            $adminData = new Admin();

            try {

                $model = Account::where("uid", '=', $data->uid)->first();

                if (!$model) {

                    $model = new Account();
                    $model->user_uid = $data->uid;
                    $model->user_card_id = isset($data->personalId) ? $data->personalId : "";
                    $model->user_prename = isset($data->prename) ? $data->prename : "";
                    $model->user_firstname_th = isset($data->firstNameThai) ? $data->firstNameThai : "";
                    $model->user_lastname_th = isset($data->lastNameThai) ? $data->lastNameThai : "";
                    $model->user_firstname_en = isset($data->cn) ? $data->cn : "";
                    $model->user_lastname_en = isset($data->sn) ? $data->sn : "";
                    $model->user_department = isset($data->department) ? $data->department : "";
                    $model->user_faculty = isset($data->faculty) ? $data->faculty : "";
                    $model->user_position = isset($data->title) ? $data->title : "";
                    $model->user_campus = isset($data->campus) ? $data->campus : "";
                    $model->user_email = isset($data->mail) ? $data->mail : "";
                    $model->save();
                }

                session(['auth' => true]);
                session(['username' => $data->uid]);
                session(['card_id' => $data->personalId]);
                session(['firstname' => $data->firstNameThai]);
                session(['lastname' => $data->lastNameThai]);
                session(['fullname' => $data->cn . " " . $data->sn]);
                session(['email' => $data->mail]);
                session(['role' => $adminData->CheckedAuthenAdmin($data->faculty) ? "admin" : "user"]);
                session(['super' => $adminData->CheckedAuthenSuper($data->uid) ? true : false]);
                session(['rmutilogin' => true]);


                return redirect()->route($adminData->CheckedAuthenAdmin($data->uid) ? "dashboard_index_page" : "calendar_index_page");
            } catch (\PDOException $th) {
                return $this->responseRedirectRoute("login_page", $th->getMessage(), "danger");
            }
        } else {

            header("location: " . "https://mis-ird.rmuti.ac.th/sso/auth/login?url=" . route("login_rmuti_data"));
            exit(0);
        }
    }

    public function actionLoginTest()
    {
        session(['auth' => true]);
        session(['username' => "jirayu.co"]);
        session(['fullname' => "jirayu chiaowet"]);
        session(['firstname' => "จิรายุ"]);
        session(['lastname' => "เชี่ยวเวช"]);
        session(['card_id' => "1309901343xxx"]);
        session(['email' => "jirayu.co@rmuti.ac.th"]);
        session(['role' => "admin"]);
        session(['rmutilogin' => false]);

        if(session('role') == 'admin'){
            return redirect()->route("dashboard_index_page");
        }else{
            return redirect()->route("calendar_index_page");
        }
    }

    public function actionLogout()
    {
        session()->forget(['auth' , 'id' , 'username' , 'fullname', 'role']);

        if(session("rmutilogin")){

            session()->forget('rmutilogin');
            
            return redirect('https://mis-ird.rmuti.ac.th/sso/auth/logout?url=' . route("login_page"));

        }else{
            return redirect()->route("login_page");
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