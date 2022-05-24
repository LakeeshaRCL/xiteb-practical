<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * a method to save new user
     */
    function save(Request $request){

        // get values
        $userName = $request->userName;
        $userContactNo =  $request->userContactNo;
        $userDOB =  $request->userDOB;
        $userEmail =  $request->userEmail;
        $userPassword =  $request->userPassword;
        $userConfirmPassword = $request->userConfirmPassword;

        if ($userPassword != $userConfirmPassword){
            return redirect('/userAuth/register')->with('feedbackMsg','Password and confirm passwords are not matched');
        }
        else{
            try{
                $newUser = new User();

                $newUser->name = $userName;
                $newUser->email = $userEmail;
                $newUser->password = Hash::make($userPassword);
                $newUser->contactNo = $userContactNo;
                $newUser->dob = $userDOB;

                $isSaved = $newUser->save();

                if($isSaved){
                    // return to dashboad
                    return redirect('/userAuth/register')->with('feedbackMsg','user saved ! user ID: '.strval($newUser->id));
                }
                else{
                    return redirect('/userAuth/register')->with('feedbackMsg','Sorry! Try again.');
                }
            }
            catch(Exception){
                return redirect('/userAuth/register')->with('feedbackMsg','Sorry! Try again.');
            }

        }

    }

    /**
     * A method to validate a user
     */
    function validateUser (Request $request){
        // get values
        $userEmail = $request->userEmail;
        $userPassword =  $request->userPassword;

        $filteredUser = User::where('email',trim($userEmail))->first();


        if($filteredUser == null){
            return back()->with("feedbackMsg","Invalid user name");
        }
        else{
            // TODO: use hashing
            //strcmp($filteredUser->password,trim($userPassword))==0
            if(Hash::check($filteredUser->password,$userPassword)){
                $request->session()->forget('loggedUser');
                $request->session()->put('loggedUser',$filteredUser->id);
                Log::info("Requested user name : ".$filteredUser->name. "ID :".$filteredUser->id);
                return redirect('/user/dashboard');
            }
            else{
                return back()->with("feedbackMsg","Invalid user name or password");
            }
        }
    }

    /**
     * A method to return the dashboard
     */
    function viewUserDashboard(){
        $data = ['loggedUserData'=> User::findOrFail(session('loggedUser'))];
        return view('user.userDashboard',$data);
    }

}
