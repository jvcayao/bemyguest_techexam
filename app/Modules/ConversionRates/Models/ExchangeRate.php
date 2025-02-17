<?php

namespace App\Modules\ConversionRates\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $table = "conversion_rate";

    protected $fillable = ['rate'];
}
