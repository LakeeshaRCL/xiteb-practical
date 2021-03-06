@extends('layouts.baseLayout')
    @section('bodyContent')
        <div class="loginArea" style="text-align: center">
            <h2>Login</h2>
            <form action="{{route('user.validateUser')}}" method="POST">
                @csrf
                <label for="email">Email</label><br>
                <input type="email" name="userEmail" required><br>
                <label for="password">Password</label><br>
                <input type="password" name="userPassword" required><br><br>

                <button type="submit" class="action-btn-accept">Login</button><br><br>
                <a href="{{route("userAuth.register")}}">New to the system? Let's create a new account!</a>

                <br><br>

                <div class="componetArea">
                    <button class="componet-btn"><a href="/">Goto Main Menu</a></button>
                </div>

                <br>
                <p class="message">{{session('feedbackMsg')}}</p>
            </form>
        </div>
        </div>
    @endsection
