<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $errors = [];
        // Check minimum length
        if (strlen($value) < 8) {
            $errors[] = 'be at least 8 characters';
        }

        // Check for at least one uppercase letter
        if (!preg_match('/[A-Z]/', $value)) {
            $errors[] = 'contain at least one uppercase letter';
        }

        // Check for at least one alphabet character (can be uppercase or lowercase)
        if (!preg_match('/[a-zA-Z]/', $value)) {
            $errors[] = 'contain at least one alphabet character';
        }

        // Check for at least one symbol (special character)
        if (!preg_match('/[^a-zA-Z\d]/', $value)) {
            $errors[] = 'contain at least one special character';
        }

        // If there are any validation errors, construct and return the failure message
        if (!empty($errors)) {
            $errorMessage = 'The password must ' . implode(', ', $errors);
            $fail($errorMessage);
        }
    }
}
