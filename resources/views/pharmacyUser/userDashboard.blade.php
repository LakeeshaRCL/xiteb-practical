@extends('layouts.baseLayout')
@section('bodyContent')
    <div class="loginArea" style="text-align: center">
        <h2>Welcome {{$loggedPharmacyUserData['name']}}</h2>

        <br>

        <div class="componetArea">
            <button class="componet-btn"><a href="{{route('prescription.getAll')}}">View Prescriptions</a></button>
            <button class="componet-btn"><a href="{{route('quotations.getAll')}}">View Quotations</a></button>
        </div>

        <br>
        <p class="message">{{session('feedbackMsg')}}</p>

        <div class="logoutArea" style="margin-top: 5%">
            <a href="{{route('pharmacyUserAuth.logout')}}">Logout</a>
        </div>
    </div>
@endsection
