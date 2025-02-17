<?php

namespace App\Modules\ConversionRates\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ConversionRates\Models\ExchangeRate;
use App\Modules\ConversionRates\Requests\ConversionRateRequest;
use App\Modules\Entities\Error;
use App\Modules\Entities\Response;
use App\Modules\Factories\ErrorFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Number;

class CurrenciesConverterController extends Controller
{
    public function convert(Request $request)
    {

        $amount = $request->input("amount");

        $quote_rules = (new ConversionRateRequest)->rules();

        Validator::make($request->all(), $quote_rules)->validate();


        $exchangeRate = ExchangeRate::first();

        if (empty($exchangeRate)) {
            ErrorFactory::addError(Error::INTERNAL_ERROR, "Exchange rate not found");
            return (new Response)->error();
        }

        $convertedAmount = $request->amount * $exchangeRate->rate;

        $data = [
            'sgd_amount' => (float) stringToFloatVal($amount),
            'exchange_rate' => $exchangeRate->rate,
            'pln_amount' => round($convertedAmount, 2),
        ];


        return (new Response)->success($data);
    }
}