<?php

namespace App\Helpers;

class ApiRequestHelper
{
    public static function validateEvenNumber()
    {
        return function ($attribute, $value, $fail) {
            if ($value % 2 !== 0) {
                $fail('The '.$attribute.' must be an even number.');
            }
        };
    }
}
