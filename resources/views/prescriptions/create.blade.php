@extends('layouts.baseLayout')
    @section('bodyContent')
        <div class="loginArea" style="text-align: center">
            <h2>Create Prescription UID - {{$userID}}</h2>
            <form action="{{route('prescription.save')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="userID" value="{{$userID}}">
                <label for="note">Note</label><br>
                <input type="text" name="note" required><br>
                <label for="address">Delivery Address</label><br>
                <input type="text" name="deliveryAddress" required><br>
                <label for="time">Delivery Time</label><br>
                <select name="deliveryTime" required><br>
                    <option value="9.00 AM">9.00 AM</option>
                    <option value="11.00 AM">11.00 AM</option>
                    <option value="1.00 PM">1.00 PM</option>
                    <option value="3.00 PM">3.00 PM</option>
                    <option value="5.00 PM">5.00 PM</option>
                    <option value="7.00 PM">7.00 PM</option>
                </select><br><br>
                <label for="images">Choose prescription images</label><br>
                <input type="file" name="image[]" multiple required> <br>
                
                <button type="submit" class="componet-btn">Upload Prescription</button>
            </form>
            <br>
        </div>
        </div>
    @endsection