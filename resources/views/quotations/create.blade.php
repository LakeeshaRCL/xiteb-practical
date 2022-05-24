@extends('layouts.baseLayout')
@section('bodyContent')
    <div class="loginArea" style="text-align: center; margin-bottom: 20%">
        <h2>Create a new quotation</h2>
        <br>
        <h4>Prescription Details</h4>
        <p><b>Note : </b>{{$prescription->note}}</p>
        <p><b>Delivery Address :</b>{{$prescription->deliveryAddress}}</p>
        <p><b>Delivery Time :</b>{{$prescription->deliveryTime}}</p>
        <h4>Prescription Images :</h4>
            <div class="prescription-images">
                @foreach($images as $image)
                    <img src="/{{$imagePath}}{{$image->name}}" style="width: 200px; height: auto">
                @endforeach
            </div>
        <br>
        <div class="added-items" id="addedItemDiv">
            <table border="0" class="item-table" id="itemListTable" style="border-collapse: collapse;">
                <tr>
                    <th>Drug</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </table>

        </div>
            <p id="totalDisplay"></p>
            <br><br>

            <h4>Add drugs to quotation</h4>
            <label for="drug">Drug </label>
            <select name="drugDetails" required id="drugDetails"><br>
                @foreach($availableDrugs as $drug)
                    <option value="{{$drug->id}}-{{$drug->name}}-{{$drug->unitPrice}}">{{$drug->name}}</option>
                @endforeach
            </select><br><br>
            <label for="qty">Quantity</label>
            <input type="number" name="quantity" id="quantity">
            <button onclick="addInputFieldsToItemListForm();">Add</button>

        <br>
        <hr style="border: 1px black solid;">
        <!-- Data sending form -->
        <h4>Send This Quotation</h4>
        <form action="{{route('quotations.save')}}" method="post" id="finalItemListForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="prescriptionID" value="{{$prescription->id}}">

            <button type="submit">Send Quotation</button>
        </form>

    </div>
    <script>
        var total = 0;
        function addInputFieldsToItemListForm(){

            let qty = document.getElementById('quantity').value;
            let drugDetails =  document.getElementById('drugDetails').value;

            // Get drug details
            let drugDetailsArray = drugDetails.split("-");
            let drugId = drugDetailsArray[0];
            let drugName = drugDetailsArray[1];
            let drugUnitPrice = drugDetailsArray[2];

            let price = drugUnitPrice*qty;
            total = total+price;

            var table = document.getElementById('itemListTable');

            var row = table.insertRow();
            var cellDrug = row.insertCell(0);
            var cellQty = row.insertCell(1);
            var cellPrice = row.insertCell(2);

            // add items to table cells
            cellDrug.innerHTML= drugName;
            cellQty.innerHTML = drugUnitPrice+" x "+qty;
            cellPrice.innerHTML = price.toString();

             if(total > 0){ // display total if there are items
                 document.getElementById("totalDisplay").innerHTML  = "Total: "+total.toString();
             }

            // add input fields to the final form
            var drugIdInputBox = document.createElement("INPUT");
             drugIdInputBox.setAttribute("type","hidden");
             drugIdInputBox.setAttribute('name','drugID[]');
             drugIdInputBox.setAttribute('value',drugId);

             document.getElementById("finalItemListForm").appendChild(drugIdInputBox);

            var quantityInputBox = document.createElement("INPUT");
            quantityInputBox.setAttribute("type","hidden");
            quantityInputBox.setAttribute('name','quantity[]');
            quantityInputBox.setAttribute('value',qty);

            document.getElementById("finalItemListForm").appendChild(quantityInputBox);

        }
    </script>
@endsection
