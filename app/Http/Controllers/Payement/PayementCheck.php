<?php

namespace App\Http\Controllers\Payement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayementCheck extends Controller
{
    public function check(Request $request){
        Log::info('checked payement');
        Log::info($request->pid);
        if (!$request->ajax()) {
            abort(404);
        }
        return response('Hello World', 200)
                  ->header('Content-Type', 'text/plain');
    }
}
