@extends('layouts.baseLayout')
@section('bodyContent')
    <div class="loginArea" style="text-align: center">
        <h2>All Prescriptions</h2>
        <br>
        <table class="item-table" style="border-collapse: collapse;">
            <tr>
                <th>Note</th>
                <th>Delivery Address</th>
                <th>Delivery Time</th>
                <th>Actions</th>
            </tr>
            @foreach($prescriptions as $prescription)
                <tr>
                    <td>{{$prescription->note}}</td>
                    <td>{{$prescription->deliveryAddress}}</td>
                    <td>{{$prescription->deliveryTime}}</td>
                    @if(!$prescription->isQuotationCreated)
                        <td><button class="action-btn-info"><a href="{{route('quotations.create',$prescription->id)}}">Create Quotation</a></button></td>
                    @else
                        <td><button disabled class="action-btn-info">Create Quotation</button></td>
                    @endif
                </tr>
            @endforeach
        </table>
        <br>
        <div class="componetArea">
            <button class="componet-btn"><a href="{{route('pharmacyUser.userDashboard')}}">Goto Dashboard</a></button>
        </div>
        <p class="message">{{session('feedbackMsg')}}</p>
        <br>
    </div>
@endsection
