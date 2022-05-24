<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PharmacyUserAuthController extends Controller
{
    // A method to show login screen
    function login(){
        return view('auth.pharmacyUserLogin');
    }

    // A method to logout the user
   function logout(){
        if(session()->has('loggedPharmacyUserID')){
            session()->pull('loggedPharmacyUserID');
            return redirect('/pharmacyUserAuth/login');
        }
   }
}
