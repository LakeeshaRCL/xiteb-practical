@extends('layouts.baseLayout')
    @section('bodyContent')
        <div class="content" style="text-align:center; font-size:80px; color:grey;">

            <br>
            <p class="message">{{session('feedbackMsg')}}</p>
           
            <div class="buttonArea">

            </div>
        </div>
    @endsection