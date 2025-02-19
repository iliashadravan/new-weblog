<?php

namespace App\Http\Controllers;

use App\Http\Requests\SmsController\SmsRequest;
use App\Service\SmsService;

class SmsController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function sendSms(SmsRequest $request)
    {
        $receptor = $request->input('phone');
        $message = "کد تأیید شما: " . rand(10000, 99999);

        $isSent = $this->smsService->sendSms($receptor, $message);

        if ($isSent) {
            return response()->json(['success' => true, 'message' => 'پیامک ارسال شد!']);
        }

        return response()->json(['success' => false, 'error' => 'خطا در ارسال پیامک!']);
    }
}
