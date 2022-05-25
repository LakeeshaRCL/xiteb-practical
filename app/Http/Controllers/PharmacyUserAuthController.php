<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PharmacyUserAuthController extends Controller
{
    /*
     * This method is used show the login screen of the pharmacy users
     */
    function login(){
        return view('auth.pharmacyUserLogin');
    }

    /*
     * This method is used to logout a pharmacy user
     */
   function logout(){
        if(session()->has('loggedPharmacyUserID')){
            session()->pull('loggedPharmacyUserID');
            return redirect('/pharmacyUserAuth/login');
        }
   }
}
