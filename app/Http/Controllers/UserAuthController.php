<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAuthController extends Controller
{

    /*
     * This method is used to return the login view to the user
     */
    function login(){
        return view('auth.userLogin');
    }

    /*
     * This method is used to return the register view to the user
     */
    function register(){
        return view('auth.userRegister');
    }

    /*
     * This method is used to logout a user
     */
    function logout() {
        if(session()->has("loggedUser")){
            session()->pull("loggedUser");
            session()->flush();
            return redirect("/userAuth/login");
        }
    }
}
