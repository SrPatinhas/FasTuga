<?php

namespace App\Utils;

use Illuminate\Support\Facades\Http;

/**
 * Created by PhpStorm.
 * Project: FasTuga
 * User: Miguel Cerejo
 * Date: 12/22/2022
 * Time: 2:04 AM
 *
 * File: Utils.php
 */
class Utils
{

    public function callPaymentGateway($pay_type, $pay_reference, $order_value, $isRefund = false)
    {
        $url = 'https://dad-202223-payments-api.vercel.app';
        if($isRefund){
            $url = $url . '/api/refunds';
        } else {
            $url = $url . '/api/payments';
        }
        $response = Http::post($url, [
            "type"      => strtolower($pay_type),
            "reference" => $pay_reference,
            "value"     => (float) $order_value
        ]);

        if ($response->status() == 201) {
            return true;
        }
        return false;
    }

    public function checkPayment($pay_type, $pay_reference, $order_value)
    {
        $paymentValid = false;
        $pay_type = strtolower($pay_type);
        if ($pay_type === "visa") { // for a Visa payment is the Visa Card ID with 16 digits;
            // Test visa
            $paymentValid = preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $pay_reference);
            if(!$paymentValid){
                // Test visaMaster
                $paymentValid = preg_match('/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14})$/', $pay_reference);
            }
            $paymentValid = $paymentValid && $order_value < 200;
        } else if ($pay_type === "paypal") { // the reference for the PayPal is a valid email
            $paymentValid = filter_var($pay_reference, FILTER_VALIDATE_EMAIL) && preg_match('/\.(pt|com)$/', $pay_reference);
            $paymentValid = $paymentValid && $order_value < 50;
        } else if ($pay_type === "mbway") { // the reference for the MbWay is the mobile phone number with 9 digits
            $paymentValid =  preg_match('/^(9)[0-9]{8}$/', $pay_reference);
            $paymentValid = $paymentValid && $order_value < 10;
        }
        return $paymentValid;
    }
}
