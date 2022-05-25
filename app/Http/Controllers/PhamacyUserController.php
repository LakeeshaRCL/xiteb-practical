<?php

namespace App\Http\Controllers;

use App\Models\PharmacyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PhamacyUserController extends Controller
{
    // This method is used to validate a pharmacy user
    function validateUser(Request $request)
    {
        // get values
        $phUserEmail = $request->phUserEmail;
        $phUserPassword =  $request->phUserPassword;

        $filteredPhUser = PharmacyUser::where('email',trim($phUserEmail))->first();

        if($filteredPhUser == null){
            return back()->with("feedbackMsg","Invalid user name");
        }
        else{
            if(strcmp($filteredPhUser->password,trim($phUserPassword))==0){

                $request->session()->put('loggedPharmacyUserID',$filteredPhUser->id);
                return redirect('/pharmacyUser/userDashboard');
            }
            else{
                return back()->with("feedbackMsg","Invalid user name or password");
            }
        }
    }

    /**
     * This method is used to return the dashboard
     */
    function viewDashboard(){

        $loggedUser= pharmacyUser::findOrFail(session('loggedPharmacyUserID'));

        $data = ['loggedPharmacyUserData' => $loggedUser];
        Log::info("Inside route function - userNAme: ".$loggedUser->name);
        return view('pharmacyUser.userDashboard',$data);


    }

}
