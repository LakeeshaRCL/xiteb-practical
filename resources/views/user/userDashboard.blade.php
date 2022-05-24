@extends('layouts.baseLayout')
    @section('bodyContent')
        <div class="loginArea" style="text-align: center">
            <h2>Welcome {{$loggedUserData['name']}}</h2>

            <br>
            <div class="componetArea">
                <button class="componet-btn"><a href="{{route('prescription.create',$loggedUserData['id'])}}">Create Prescription</a></button>
                <button class="componet-btn"><a href="">View Quotations</a></button>
            </div>
            
            <br>
            <p class="message">{{session('feedbackMsg')}}</p>

            <div class="logoutArea" style="margin-top: 5%">
                <a href="{{route('userAuth.logout')}}">Logout</a>
            </div>
            
           
        </div>
        </div>
    @endsection