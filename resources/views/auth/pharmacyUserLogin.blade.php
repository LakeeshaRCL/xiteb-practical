@extends('layouts.baseLayout')
@section('bodyContent')
    <div class="loginArea" style="text-align: center">
        <h2>Pharmacy User - Login</h2>
        <form action="{{route('pharmacyUser.validate')}}" method="POST">
            @csrf
            <label for="email">Email</label><br>
            <input type="email" name="phUserEmail" required><br>
            <label for="password">Password</label><br>
            <input type="password" name="phUserPassword" required><br><br>

            <button type="submit" class="action-btn-accept">Login</button><br><br>

            <br><br>

            <div class="componetArea">
                <button class="componet-btn"><a href="/">Goto Main Menu</a></button>
            </div>

            <br>
            <p class="message">{{session('feedbackMsg')}}</p>
        </form>
    </div>
@endsection
