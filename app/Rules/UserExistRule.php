<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UserExistRule implements Rule
{

    private $column;
    private $except;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($column = 'email', $except = null)
    {
        $this->column = $column;
        $this->except = $except;
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
        $user = User::where($this->column, $value);

        if($this->except){
            $user = $user->whereNot('id', $this->except);
        }
        return $user->count() == 0 ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This :attribute is already exist in Users table.';
    }
}
