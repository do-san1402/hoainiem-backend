<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

trait FormRequestTrait
{
    /**
     * Customize the response for validation errors.
     *
     * @param  Validator  $validator
     * @return void
     */
    public function failedValidation(Validator $validator)
    {

        if ($this->ajax()) {
            $response = response()->json([
                'success' => false,
                'message' => localize("Validation error"),
                'errors'  => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $response = redirect()->back()->withErrors($validator)->withInput();
        }

        throw new HttpResponseException($response);

    }

}
