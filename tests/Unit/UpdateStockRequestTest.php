<?php

namespace Tests\Unit;

use App\Http\Requests\UpdateStockRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateStockRequestTest extends TestCase
{
    public function testValidationRules()
    {
        $request = new UpdateStockRequest();

        $validator = Validator::make([
            'timestamp' => now(),
            'open' => 150,
            'high' => 155,
            'low' => 145,
            'close' => 152,
            'volume' => 1000,
            'previous_close' => 148,
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }

    public function testValidationFails()
    {
        $request = new UpdateStockRequest();

        $validator = Validator::make([
            'timestamp' => 'invalid-date',
            'open' => 'invalid',
            'high' => 'invalid',
            'low' => 'invalid',
            'close' => 'invalid',
            'volume' => 'invalid',
            'previous_close' => 'invalid',
        ], $request->rules());

        $this->assertFalse($validator->passes());
    }
}
