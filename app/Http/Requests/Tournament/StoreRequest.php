<?php

namespace App\Http\Requests\Tournament;

use App\Helpers\ApiRequestHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'gender' => 'required|in:man,woman',
            'players_amount' => ['required', 'integer', 'min:2', 'max:32', ApiRequestHelper::validateEvenNumber()],
            'player_id' => 'nullable|integer|exists:players,id',
        ];
    }

    

    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(
            [
                'success' => false,
                'message' => 'Validation errors',
                'data' => $validator->errors()
            ], 400
        ));
    }
}
