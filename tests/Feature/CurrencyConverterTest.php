<?php

namespace Tests\Feature;

use App\Modules\ConversionRates\Models\ExchangeRate;
use App\Modules\Entities\Error;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyConverterTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;
    protected $seeders = [DatabaseSeeder::class];

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_success_conversion_rate(): void
    {
        $response = $this->get(url()->query('/api/convert', ['amount' => 100]));

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true,
            'data' => [
                'sgd_amount' => 100,
                'exchange_rate' => 2.96,
                'pln_amount' => 296,
            ],
        ]);
    }

    public function test_validation_failed_response()
    {
        $response = $this->get(url()->query('/api/convert', ['amount' => 0]));

        $response->assertStatus(422);

        $response->assertJson([
            'success' => false,
            'errors' => [
                [
                    "code" => Error::VALIDATION_FAILED
                ]
            ]
        ]);
    }

   
}


