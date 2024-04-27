<?php

namespace App\Rules;

use App\Helpers\Helper;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Builder;

class UniquePhone implements ValidationRule
{
    public function __construct(private $user)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $phoneWithCode = request()->input('country_code') . request()->input('phone_number');

        $user = User::query();

        /**
         * ignore validation for this user
         */
        if ($this->user)
            $user->where('username', '!=', $this->user['username']);

        $phoneIsUnique = $user->where('phone_number', $phoneWithCode)->count();

        $attribute = Helper::convertToNormalWords($attribute, 'lower');

        if ($phoneIsUnique > 0)
            $fail("The {$attribute} has already been taken.");
    }
}
