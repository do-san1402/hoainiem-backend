<?php

namespace Modules\News\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class NewsPositionUpdateRequest extends FormRequest
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
            'position'   => ['required', 'array', 'min:1'],
            'position.*' => ['required', 'integer'],
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
