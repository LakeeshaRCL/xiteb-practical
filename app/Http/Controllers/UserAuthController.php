<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAuthController extends Controller
{

    // login view
    function login(){
        return view('auth.userLogin');
    }

    // register new user
    function register(){
        return view('auth.userRegister');
    }

      /**
     * A method to logout the user
     */
    function logout() {
        if(session()->has("loggedUser")){
            session()->pull("loggedUser");
            session()->flush();
            return redirect("/userAuth/login");
        }
    }
}
