@extends('layouts.baseLayout')
@section('bodyContent')
    <div class="loginArea" style="text-align: center">
        <h2>All Prescriptions</h2>
        <br>

        @foreach($prescriptions as $prescription)
            <p>{{$prescription->note}}</p>
        @endforeach
        <br>
        <br>

    </div>
@endsection
