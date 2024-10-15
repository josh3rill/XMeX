<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust as needed for authorization logic
    }

    public function rules()
    {
        return [
            'timestamp' => 'required|date',
            'open' => 'required|numeric',
            'high' => 'required|numeric',
            'low' => 'required|numeric',
            'close' => 'required|numeric',
            'volume' => 'required|integer',
            'previous_close' => 'required|numeric',
        ];
    }
}