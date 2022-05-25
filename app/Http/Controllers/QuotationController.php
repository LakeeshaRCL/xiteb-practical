<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\DrugsQuotations;
use App\Models\Image;
use App\Models\Prescription;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuotationController extends Controller
{

    /*
     * This method is used to return quotation details by user id
     */
    function showQuotations($userID){

        try {
            // get all prescriptions
            $prescriptions = Prescription::where('userID', $userID)->get();

            // to store prescription notes
            $prescriptionNotes = array();

            // array to store user quotations
            $allUserQuotations = array();

            // array to store quotation drug details
            $allQuotationDrugDetailList = array();

            foreach ($prescriptions as $prescription) {

                // get quotation data related the user
                $quotation = Quotation::where('prescriptionID', $prescription->id)->get()->first();

                if ($quotation) {
                    array_push($prescriptionNotes, $prescription->note);
                    array_push($allUserQuotations, $quotation);


                    // get drug list
                    $currentDrugQuotationList = DrugsQuotations::where("quotationID", $quotation->id)->get();

                    $currentQuotationDrugList = array(); // used to store current quotation drug list
                    $currentDrugDetailList = []; // used to store drug details of the list

                    foreach ($currentDrugQuotationList as $currentDrugQuotation) {

                        // add to the array
                        $drug = Drug::where('id', $currentDrugQuotation->drugID)->get()->first();
                        $currentDrugDetailList['drugName'] = $drug->name;
                        $currentDrugDetailList['drugQty'] = $currentDrugQuotation->quantity;
                        $currentDrugDetailList['totalDrugPrice'] = (int)$currentDrugQuotation->quantity * $drug->unitPrice;

                        array_push($currentQuotationDrugList, $currentDrugDetailList);
                    }
                    array_push($allQuotationDrugDetailList, $currentQuotationDrugList);
                }
                $quotation = null;
            }
            //        return view('quotations.showQuotations',data:['userID'=>$userID]);
            return view('quotations.showQuotations', data: [
                "prescriptionNotes" =>$prescriptionNotes,
                "userQuotations"=>$allUserQuotations,
                "allQuotationDrugDetailsList"=>$allQuotationDrugDetailList
            ] );

        }
        catch (\Exception $e){
            Log::error("Error in QuotationController getAll() : ".strval($e));
            return redirect('/user/dashboard')->with('feedbackMsg', "Sorry! Try again.");
        }
    }


    /*
     * This method is used to list all quotations
     */
    function getAll(){

        // get quotation data
        $allQuotations = Quotation::all();

        // to store username data
        $quotationUserNames = array();

        // to store the all quotation drug details list
        $allQuotationDrugDetailList = array();

       try{
          foreach ($allQuotations as $quotation){

              // get usernames
              $currentUserName =  User::findOrFail(Prescription::findOrFail($quotation->prescriptionID)->userID)->name;
              array_push($quotationUserNames,$currentUserName);

              // get drug list
              $currentDrugQuotationList = DrugsQuotations::where("quotationID",$quotation->id)->get();

              $currentQuotationDrugList = array(); // used to store current quotation drug list
              $currentDrugDetailList= []; // used to store drug details of the list

              foreach ($currentDrugQuotationList as $currentDrugQuotation){

                  // add to the array
                  $drug = Drug::where('id',$currentDrugQuotation->drugID)->get()->first();
                  $currentDrugDetailList['drugName'] = $drug->name;
                  $currentDrugDetailList['drugQty'] = $currentDrugQuotation->quantity;
                  $currentDrugDetailList['totalDrugPrice'] = (int)$currentDrugQuotation->quantity * $drug->unitPrice;

                  array_push($currentQuotationDrugList,$currentDrugDetailList);
              }
              array_push($allQuotationDrugDetailList,$currentQuotationDrugList);
          }
           return view('quotations.index',data:[
               'allQuotations'=>$allQuotations,
               'quotationUserNames'=>$quotationUserNames,
               'allQuotationsDrugDetailList'=>$allQuotationDrugDetailList
           ]);
       }
       catch (\Exception $e){
           Log::error("Error in QuotationController getAll() : ".strval($e));
           return redirect('/pharmacyUser/userDashboard')->with('feedbackMsg','Sorry! Try again.');
       }
    }

    /*
     * This method is used to create new quotation
     */
    function create($presID){

        // get prescription
        $currentPrescription = Prescription::findOrFail($presID);

        //get images
        $images = Image::where('prescriptionID',"=",$presID)->get();
        $imagePath = config('app.fileUploadPath');

        // get available drugs
        $drugs = Drug::latest()->get();

        return view('quotations.create',
            data:[
            'prescription'=>$currentPrescription,
            'images' => $images,
            'imagePath' => $imagePath,
            'availableDrugs'=> $drugs
            ]
        );
    }


    /**
     * This method is used to save a new quotation
     *
     */
    function save(Request $request){
        // get values
        $drugIDs = $request->drugID;
        $quantities = $request->quantity;
        $prescriptionID = $request->prescriptionID;

        try{
            // get the prescription to update the quotation creation
            $prescription = Prescription::findOrFail($prescriptionID);

            // save new quotation
            $newQuotation = new Quotation();

            $newQuotation->userFeedbackStatus="Pending"; // initial user feedback status
            $newQuotation->prescriptionID=$prescriptionID;

            $newQuotation->save();

            //update prescription
            $prescription->isQuotationCreated = true;
            $prescription->save();

            for ($index =0 ; $index<count($drugIDs); $index++){
                Log::info("Record - Drug ID : ".$drugIDs[$index]." Qty : ".$quantities[$index]);

                // save new pivot table values - drugQuotation table
                $newDrugQuotation = new DrugsQuotations();
                $newDrugQuotation->drugID=$drugIDs[$index];
                $newDrugQuotation->quotationID=$newQuotation->id;
                $newDrugQuotation->quantity=$quantities[$index];

                $newDrugQuotation->save();
            }

            return redirect('/prescription/getAll')->with('feedbackMsg','The Quotation has been uploaded successfully!');
        }
        catch(\Exception $e){
            Log::error("Error in QuotationController Save() : ".strval($e));
            return redirect('/prescription/getAll')->with('feedbackMsg','Try again! Unable to upload.');
        }
    }

    /**
     * This method is used to update quotation feedback using quotation id
     *
     */
    function updateFeedback($quoID,Request $request){
        // get values
        $action = $request->action;

        $quotation = Quotation::findOrFail($quoID);
        $quotation->userFeedbackStatus =$action;
        $quotation->save();

        return redirect()->back();
    }
}
