<?php

namespace App\Rules;

use App\Models\SchoolClass;
use Illuminate\Contracts\Validation\Rule;

class IsSchoolClass implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return SchoolClass::validateNormal($value) || SchoolClass::validateYear($value) ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return  __('Zadaná třída je ve špatném formátu.');
    }
}
