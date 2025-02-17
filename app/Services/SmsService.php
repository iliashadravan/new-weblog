<?php

namespace App\Services;

use Kavenegar\KavenegarApi;

class SmsService
{
    protected $api;

    public function __construct()
    {
        $this->api = new KavenegarApi(env('KAVENEGAR_API_KEY'));
    }

    public function sendSms($receptor, $message)
    {
        try {
            $sender = "10008663";
            $this->api->Send($sender, $receptor, $message);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
