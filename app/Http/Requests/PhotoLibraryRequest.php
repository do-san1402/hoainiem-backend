<?php

namespace App\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class PhotoLibraryRequest extends FormRequest
{
    use FormRequestTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'thumb_height' => ['required', 'integer'],
            'thumb_width'  => ['required', 'integer'],
            'large_height' => ['required', 'integer'],
            'large_width'  => ['required', 'integer'],
            'image'        => ["required", 'file', 'image', 'max:5120'],
            'caption'      => ['nullable', 'string'],
            'reference'    => ['nullable', 'string'],
        ];
    }
}
