<?php

namespace App\Exports;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Psr\Http\Message\ResponseInterface;
use stdClass;

class AttemptTask
{

    public static function passer($uri, array $data, $key_contrat)
    {
        /*Log::info('test'. AttemptTask::class);*/
        $_params = "?";
        foreach ($data as $key => $value) {
            $_params .= $key . '=' . urlencode(json_encode($value)) . '&';
        }

        $url = $uri . '' . $_params;
        $header = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json';
        $header[] = 'Authorization: OAuth SomeHugeOAuthaccess_tokenThatIReceivedAsAString';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, FALSE);
        curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
        //curl_setopt($curl, CURLOPT_USERAGENT, 'api');
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl,  CURLOPT_RETURNTRANSFER, false);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
        curl_exec($curl);
        curl_close($curl);
    }

    public static function post($url, array $data, $key_contrat, $request)
    {
        $header = array();
        //$header[] = 'Content-length: 0';
        $header[] = 'Content-Type: application/json;charset=UTF-8';
       $header[] = 'Authorization: OAuth SomeHugeOAuthaccess_tokenThatIReceivedAsAString';
        $header[] = 'X-CSRF-TOKEN: ' . $request->session()->token();
        $cookies = "";
        foreach ($_COOKIE as $key => $value) {
            $cookies .= "{$key}={$value};";
        }
        $header[] = "Cookie: {$cookies}";
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        //curl_setopt($curl, CURLOPT_USERAGENT, 'api');
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl,  CURLOPT_RETURNTRANSFER, false);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($curl, CURLOPT_POST, TRUE);//pas obligatoire
        curl_setopt($curl, CURLOPT_HEADER, false);//pas obligatoire
        curl_setopt($curl, CURLOPT_FORBID_REUSE, true);//pas obligatoire
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);//pas obligatoire
        curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 10);//pas obligatoire

        curl_exec($curl);

        curl_close($curl);
    }
}
