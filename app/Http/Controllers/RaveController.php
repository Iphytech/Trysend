<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Rave;

class RaveController extends Controller
{

    public function index() {
    //get the banks fro the flw api
        $country = 'NG';
        $data = Rave::listofBankForTransfer($country);
        $banks = json_decode(json_encode($data), true); //dd($data);
     // return $banks;
        return view('home')->with('banks', $banks);
    }
    public function initialize(Request $request) {
        session([
            'bankcode' => $request->account_bank,
            'acctnumber' => $request->account_number,
            'narration' => $request->narration,
        ]);

        //This initializes payment and redirects to the payment gateway
        //The initialize method takes the parameter of the redirect URL
        Rave::initialize(route('callback'));
      }
      public function callback() {
      // This verifies the transaction and takes the parameter of the transaction reference
        $data = Rave::verifyTransaction(request()->txref);
            $chargeResponsecode = $data->data->chargecode;
            $chargeAmount = $data->data->amount;
            $chargeCurrency = $data->data->currency;
            $amount = $data->data->amount;
            $currency = "NGN";

        if (($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($chargeAmount == $amount)  && ($chargeCurrency == $currency)) {
        // transaction was successful...
        // please check other things like whether you already gave value for this ref
        // if the email matches the customer who owns the product etc
        //Give Value and return to Success page
            session([
                'amount' => $amount,
                'currency' => $currency
            ]);
            
            return redirect('/transfer');
        } else {
            //Dont Give Value and return to Failure page
            return redirect('/failed');
        }
            // dd($data);
        }
        public function initiateTransfer() {
            // return session('bankcode');
            $arrdata = array(
                'account_bank' => session('bankcode'),
                'account_number' => session('acctnumber'),
                'amount' => session('amount'),
                'narration' => session('narration'),
                'reference' => 'TS_'.time(),
                'currency' => session('currency'),
                'seckey' => 'FLWSECK-cdbf6713ce1ceb507b1f03fa44040f56-X',
                'callback_url' => '/success'
            );
            $data = Rave::initiateTransfer($arrdata);
            // dd($data);
            $status = $data->status;

            if($status == 'success') {
                return redirect('/success');
            }
            else {
                return redirect('/failed');
            }

}
    public function success() {
        return 'Transfer is successful';
    }
    public function failed() {
        return 'Transfer is unsuccessful, Please try again';
    }

}