<?php

namespace Modules\Menu\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMenuContentRequest extends FormRequest
{
    use FormRequestTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'level'     => ['required', 'string'],
            'slug'      => ['nullable', 'string'],
            'position'  => ['nullable', 'string'],
            'link'      => ['nullable', 'string'],
            'parent_id' => ['nullable', 'integer'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
