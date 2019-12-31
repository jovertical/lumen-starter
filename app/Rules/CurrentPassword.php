<?php

declare(strict_types=1);

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

class CurrentPassword implements Rule
{
    /**
     * The email of the user.
     */
    protected ?string $email;

    /**
     * Create a new Rule instance.
     */
    public function __construct(?string $email)
    {
        $this->email = $email;
    }

    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool
    {
        $user = User::where('email', $this->email)->first();

        return $user ? Hash::check($value, $user->password) : true;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return Lang::get('auth.password_mismatch');
    }
}
