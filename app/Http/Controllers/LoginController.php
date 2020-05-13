<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\PreferenceModel;
use App\Models\GenreModel;
use App\ApiConnector\LoginApiHandler;
use App\ApiConnector\GenreApiHandler;

class LoginController extends Controller
{
    public function index()
    {        
        return view("Login");
    }

    public function CheckLogin(Request $request)
    {
        $login_data = [
            "username" => $request->username,
            "password" => $request->password
        ];
        
        $loginHandler = new LoginApiHandler();
        $data = $loginHandler->login($login_data);

        if(empty($data)){
            return redirect('/Login');//"login attempt failed";
        }

        return $this->HandleLogin($data);
    }

    public function Logout()
    {
        session()->forget('user');
        return redirect("/");
    }

    public function Registration()
    {
        $genreApiHandler = new GenreApiHandler();
        $response = $genreApiHandler->GetAllGenres();

        $genreModel = new  GenreModel();
        $genres = $genreModel->FillWithDataArray($response);

        return view("registration", ["genres" => $genres]);
    }

    public function Register(Request $request)
    {
        $preferenceModel = new PreferenceModel();
        
        $userModel = new UserModel();
        $userModel->name = $request->name;
        $userModel->username = $request->username;
        $userModel->password = $request->password;
        $userModel->right_id = 2;
        $userModel->preference = $preferenceModel->FillWithDataArray(json_decode($request->preference));

        $loginHandler = new LoginApiHandler();
        $result = $loginHandler->AddUser($userModel);

        return $this->HandleLogin($result);
        //dd($result);
    }

    public function HandleLogin($data)
    {
        $userModel = new UserModel();
        $userModel->FillWithData($data);
        
        session(['user' => $userModel]);

        if(!empty($userModel) && $userModel->right->admin){
            return redirect("/admin/events");
        } else if(!empty($userModel) && $userModel->right->admin == false){
            return redirect("/");
        }
        
        return redirect('/login');//"login attempt failed";
    }
}
