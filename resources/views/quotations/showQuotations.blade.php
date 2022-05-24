@extends('layouts.baseLayout')
@section('bodyContent')
    <div class="loginArea" style="text-align: center">
        <h2>All Your Quotations</h2>
        <br>
        <table class="item-table" style="border-collapse: collapse;">
            <tr>
                <th>Quotation Number</th>
                <th>Prescription Note</th>
                <th>Drug List</th>
                <th>Total Amount</th>
                <th>Current Status</th>
                <th>Feedback</th>
            </tr>

            @for($quotation =0; $quotation<count($userQuotations);$quotation++)
                @php
                    $quotationTotal = 0.0;
                @endphp
                <tr>
                    <td>{{$userQuotations[$quotation]->id}}</td>
                    <td>{{$prescriptionNotes[$quotation]}}</td>
                    <td>
                        <ul>
                            @for($drug =0; $drug<count($allQuotationDrugDetailsList[$quotation]);$drug++)
                                @php
                                    $drugName = $allQuotationDrugDetailsList[$quotation][$drug]['drugName'];
                                    $drugQty = $allQuotationDrugDetailsList[$quotation][$drug]['drugQty'];
                                    $quotationTotal += $allQuotationDrugDetailsList[$quotation][$drug]['totalDrugPrice'];
                                @endphp
                                <li>{{$drugName}} x {{$drugQty}}</li>
                            @endfor
                        </ul>
                    </td>
                    <td>{{round($quotationTotal,2)}}</td>
                    <td>{{$userQuotations[$quotation]->userFeedbackStatus}}</td>
                    <td>
                        <form action="{{route('quotations.updateFeedback',$userQuotations[$quotation]->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="action-btn-accept" name="action" value="Accept">Accept</button>
                            <button type="submit" class="action-btn-reject" name="action" value="Reject">Reject</button>
                        </form>
                    </td>
                </tr>
            @endfor
        </table>
        <div class="componetArea">
            <button class="componet-btn"><a href="{{route('user.dashboard')}}">Goto Dashboard</a></button>
        </div>
        <br>
    </div>
    </div>
@endsection
