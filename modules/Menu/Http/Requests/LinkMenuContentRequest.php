<?php

namespace Modules\Menu\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Menu\Entities\Link;

class LinkMenuContentRequest extends FormRequest
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
            'content_id'   => ['required', 'array', 'min:1'],
            'content_id.*' => ['required', 'integer', Rule::exists(Link::class, 'id')],
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
