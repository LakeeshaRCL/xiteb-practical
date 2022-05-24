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
    // A method to creat new prescription
    function create($userID){
        return view('prescriptions.create',data:[
            'userID'=>$userID
        ]);
    }


    // A method to save a new prescription
    function save(Request $request){
        //get values
        $userID = $request->userID;
        $note = $request-> note;
        $deliveryAddress = $request->deliveryAddress;
        $deliveryTime = $request->deliveryTime;

        try{
            $newPrescription = new Prescription();

            $newPrescription->deliveryAddress =$deliveryAddress;
            $newPrescription->note = $note;
            $newPrescription->deliveryTime = $deliveryTime;
            $newPrescription->userID = $userID;

            // save prescription
            $isSaved = $newPrescription->save();

            if($isSaved){
                // save images to db
                $imgFiles = $request->file('image');
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
            }
            else {
                return redirect('/user/dashboard')->with('feedbackMsg',"Sorry! Prescription was not uploaded. Try again.");
            }
        }
        catch(Exception $e){
            Log::error("An error occurred in PrescriptipnController, Save method : ".strval($e));
        }

        return redirect('/user/dashboard')->with('feedbackMsg',"Your prescription has been uploaded.");

        //  dd($request->file('image'));
    }

    /**
     * A method to view all prescriptions
     */
    function getAll() {
        $prescriptions = Prescription::latest()->get();
        return view('prescriptions.index',data:['prescriptions'=>$prescriptions]);
//        return $prescriptions;
    }
}
