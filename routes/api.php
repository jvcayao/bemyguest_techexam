<?php

use App\Modules\ConversionRates\Controllers\CurrenciesConverterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\ConversionRates\Controllers\DebugController;



Route::get('/convert',[CurrenciesConverterController::class,'convert']);