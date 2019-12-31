<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;

class StrongPassword implements Rule
{
    /**
     * The error message set if the validation doesn't pass.
     */
    protected $message;

    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value)
    {
        $errors = [];

        if (! preg_match('/[\W]+/', $value)) {
            $errors[] = Lang::get('validation.has.symbol', compact('attribute'));
        }

        if (! preg_match('/[0-9]/', $value)) {
            $errors[] = Lang::get('validation.has.number', compact('attribute'));
        }

        if (! preg_match('/[A-Z]/', $value)) {
            $errors[] = Lang::get('validation.has.uppercase', compact('attribute'));
        }

        if (! preg_match('/[a-z]/', $value)) {
            $errors[] = Lang::get('validation.has.lowercase', compact('attribute'));
        }

        if (count($errors)) {
            $this->message = $errors[0];
        }

        return ! count($errors);
    }

    /**
     * Get the validation error message.
     */
    public function message(): ?string
    {
        return $this->message;
    }
}
