<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Prescription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Queue\Connectors\RedisConnector;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\RequestStack;

class PrescriptionController extends Controller
{
    /*
     * This method is used return prescription creation view to users
     */
    function create($userID){
        return view('prescriptions.create',data:[
            'userID'=>$userID
        ]);
    }


    /*
     * This method is used save a new prescription
     */
    function save(Request $request){
        //get values
        $userID = $request->userID;
        $note = $request-> note;
        $deliveryAddress = $request->deliveryAddress;
        $deliveryTime = $request->deliveryTime;
        $imgFiles = $request->file('image');

        if(count($imgFiles)>5){
            return redirect()->back()->with('feedbackMsg',"Please select maximum of five images");
        }else{
            try{
                $newPrescription = new Prescription();

                $newPrescription->deliveryAddress =$deliveryAddress;
                $newPrescription->note = $note;
                $newPrescription->deliveryTime = $deliveryTime;
                $newPrescription->userID = $userID;
                $newPrescription->isQuotationCreated = false; // initially no quotation

                // save prescription
                $isSaved = $newPrescription->save();

                if($isSaved){
                    // save images to db

                    Log::info("imgFiles length : ".strval(count($imgFiles)));
                    if($imgFiles){
                        foreach ($imgFiles as $imgFile) {
                            $newImgName = md5(rand(1000,100000));
                            $extention = strtolower($imgFile->getClientOriginalExtension());

                            $newFullImgName = $newImgName.'.'.$extention;
                            $targetPath = 'uploads/';

                            $newImgURL = $targetPath.$newFullImgName;
                            $imgFile->move($targetPath,$newFullImgName);

                            // save each image
                            $newImage = new Image();

                            $newImage->name = $newFullImgName;
                            $newImage->prescriptionID = $newPrescription->id;

                            $newImage->save();
                        }
                    }
                    return redirect('/user/dashboard')->with('feedbackMsg',"Your prescription has been uploaded.");
                }
                else {
                    return redirect('/user/dashboard')->with('feedbackMsg',"Sorry! Prescription was not uploaded. Try again.");
                }
            }
            catch(Exception $e){
                Log::error("An error occurred in PrescriptionController, Save method : ".strval($e));
            }
        }
    }

    /**
     * This method is used to view all prescriptions
     */
    function getAll() {
        $prescriptions = Prescription::latest()->get();
        return view('prescriptions.index',data:['prescriptions'=>$prescriptions]);
    }
}
