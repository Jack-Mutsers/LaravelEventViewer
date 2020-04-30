<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;
use App\ApiConnector\LoginApiHandler;

class LoginController extends Controller
{
    public function index()
    {        
        return view("admin.Login");
    }

    public function CheckLogin(Request $request)
    {
        $login_data = [
            "username" => $request->username,
            "password" => $request->password
        ];
        
        $loginHandler = new LoginApiHandler();
        $data = $loginHandler->login($login_data);

        if(!$data){
            return "login attempt failed";
        }

        $userModel = new UserModel();
        $userModel->FillWithData($data);

        echo "login attempt succesvol";
        dd($data);
    }
}
