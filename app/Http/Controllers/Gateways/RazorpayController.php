<?php
namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\PaymentDetail;

class RazorpayController extends Controller
{
    public function payment(Request $request)
    {   
        // dd($request->all());
       $api = new Api(config('razorpay.key'), config('razorpay.secret'));

       $payment = $api->payment->fetch($request->razorpay_payment_id);

       if($request->has('razorpay_payment_id') && $request->filled('razorpay_payment_id')){
            try {
               $response = $api->payment->fetch($request->razorpay_payment_id)
                            ->capture(['amount' => $payment['amount']]);

               if($response['status'] == 'captured'){
                    // Store payment details in the database
                    $paymentDetail = new PaymentDetail();
                    $paymentDetail->razorpay_payment_id = $request->razorpay_payment_id;
                    $paymentDetail->payment_token = $request->_token ?? '';
                    $paymentDetail->amount = $response['amount'];
                    // Add more fields as needed
                    $paymentDetail->save();

                    return 'Payment Success!';
               } else {
                    return 'Payment Failed!';
               }

            }catch(\Exception $e){
                return $e->getMessage();
            }
       }
    }

    public function storePayment(Request $request)
    {
        return $this->payment($request);
    }
}
   