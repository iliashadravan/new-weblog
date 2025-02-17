<?php

namespace App\Http\Controllers;

use Kavenegar\KavenegarApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SmsController extends Controller
{
    public function sendSms(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'regex:/^09[0-9]{9}$/'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'شماره موبایل معتبر نیست!',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $api = new KavenegarApi(env('KAVENEGAR_API_KEY'));
            $sender = "10008663";
            $receptor = $request->input('phone');
            $message = "کد تأیید شما: " . rand(10000, 99999);

            $api->Send($sender, $receptor, $message);

            return response()->json(['success' => true, 'message' => 'پیامک ارسال شد!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

}
