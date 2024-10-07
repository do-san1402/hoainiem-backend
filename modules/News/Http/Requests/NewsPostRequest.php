<?php

namespace Modules\News\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Category\Entities\Category;

class NewsPostRequest extends FormRequest
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
            'other_page'          => ['required', 'string', Rule::exists(Category::class, 'slug')],
            'short_head'          => ['nullable', 'string'],
            'head_line'           => ['required', 'string'],
            'meta_description'    => ['nullable', 'string'],
            'lib_file_selected'   => ['nullable', 'array'],
            'lib_file_selected.*' => ['nullable', 'string'],
            'image_alt'           => ['nullable', 'array'],
            'image_alt.*'         => ['nullable', 'string'],
            'image_title'         => ['nullable', 'array'],
            'image_title.*'       => ['nullable', 'string'],
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
