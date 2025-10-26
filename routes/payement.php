<?php

use App\Http\Controllers\Payement\PayementCheck;
use Illuminate\Support\Facades\Route;

Route::get('check-payement', [PayementCheck::class, 'check'])->name('check-payement');

