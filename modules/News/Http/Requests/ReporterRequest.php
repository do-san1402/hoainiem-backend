<?php

namespace Modules\News\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class ReporterRequest extends FormRequest
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
            'name'        => ['required', 'string'],
            'designation' => ['required', 'string'],
            'photo'       => ["nullable", 'file', 'image', 'max:5120'],
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
