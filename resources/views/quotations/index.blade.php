@extends('layouts.baseLayout')
@section('bodyContent')
    <div class="loginArea" style="text-align: center">
        <table class="item-table" style="border-collapse: collapse;">
            <h2>All Quotations</h2>
            <tr>
                <th>Quotation Number</th>
                <th>Send To</th>
                <th>Drug List</th>
                <th>Total Amount</th>
                <th>User Feedback</th>
            </tr>
            @for($quotation =0 ;$quotation<count($allQuotations);$quotation++)
                @php
                    $quotationTotal = 0.0;
                @endphp
                <tr>
                    <td>{{$allQuotations[$quotation]->id}}</td>
                    <td>{{$quotationUserNames[$quotation]}}</td>
                    <td>
                        <ul>
                            @for($drug =0; $drug<count($allQuotationsDrugDetailList[$quotation]);$drug++)
                                @php
                                    $drugName = $allQuotationsDrugDetailList[$quotation][$drug]['drugName'];
                                    $drugQty = $allQuotationsDrugDetailList[$quotation][$drug]['drugQty'];
                                    $quotationTotal += $allQuotationsDrugDetailList[$quotation][$drug]['totalDrugPrice'];
                                @endphp
                                <li>{{$drugName}} x {{$drugQty}}</li>
                            @endfor
                        </ul>
                    </td>
                    <td>{{round($quotationTotal,2)}}</td>
                    <td>{{$allQuotations[$quotation]->userFeedbackStatus}}</td>
                </tr>
            @endfor
        </table>

        <div class="componetArea">
            <button class="componet-btn"><a href="{{route('pharmacyUser.userDashboard')}}">Goto Dashboard</a></button>
        </div>
        <p class="message">{{session('feedbackMsg')}}</p>
        <br>
    </div>
@endsection
