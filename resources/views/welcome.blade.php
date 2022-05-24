@extends('layouts.baseLayout')
    @section('bodyContent')
        <div class="content" style="text-align:center; font-size:80px; color:grey;">

            <br>
            <div class="componetArea">
                <button class="componet-btn" style="font-size: medium"><a href="{{route('userAuth.login')}}">User Area</a></button>
                <button class="componet-btn" style="font-size: medium"><a href="{{route('pharmacyUserAuth.login')}}">Pharmacy User Area</a></button>
            </div>

            <br>
            <p class="message">{{session('feedbackMsg')}}</p>

            <div class="buttonArea">

            </div>
        </div>
    @endsection
