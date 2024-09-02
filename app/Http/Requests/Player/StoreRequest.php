<?php

namespace App\Http\Requests\Player;

use Illuminate\Validation\Rule;
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
            'gender' => 'required|string',
            'skill_level' => 'required|integer|min:0|max:100',
            'strength' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
                Rule::requiredIf(function () {
                    return request('gender') === 'man';
                }),
                Rule::prohibitedIf(function () {
                    return request('gender') === 'woman';
                }),
            ],
            'speed' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
                Rule::requiredIf(function () {
                    return request('gender') === 'man';
                }),
                Rule::prohibitedIf(function () {
                    return request('gender') === 'woman';
                }),
            ],
            'reaction_time' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
                Rule::requiredIf(function () {
                    return request('gender') === 'woman';
                }),
                Rule::prohibitedIf(function () {
                    return request('gender') === 'man';
                }),
            ],
            'tournament_id' => 'required|integer|exists:tournaments,id'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'success' => false,
                'message' => 'Validation errors',
                'data' => $validator->errors()
            ], 400
        ));
    }
}
