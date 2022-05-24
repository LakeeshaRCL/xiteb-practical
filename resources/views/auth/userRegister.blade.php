@extends('layouts.baseLayout')
    @section('bodyContent')
        <div class="loginArea" style="text-align: center">
            <h2>Register</h2>
            <form action="{{route('user.save')}}" method="POST">
                @csrf
                <label for="name">Name</label><br>
                <input type="text" name="userName" required><br>
                <label for="name">Contact Number</label><br>
                <input type="number" name="userContactNo" required><br>
                <label for="name">Date of Birth</label><br>
                <input type="date" name="userDOB" required><br>
                <label for="email">Email</label><br>
                <input type="email" name="userEmail" required><br>
                <label for="password">Password</label><br>
                <input type="password" name="userPassword" required><br>
                <label for="conPassword">Confirm Password</label><br>
                <input type="password" name="userConfirmPassword" required><br><br>

                <button type="submit">Sign Up</button><br><br>
                <a href="{{route("userAuth.login")}}">Already have an account? Let's login!</a>

                <br><br>
                <p class="message">{{session('feedbackMsg')}}</p>
            </form>
        </div>
        </div>
    @endsection