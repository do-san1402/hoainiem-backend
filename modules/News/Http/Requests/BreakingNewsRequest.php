<?php

namespace Modules\News\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class BreakingNewsRequest extends FormRequest
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
            'breaking_news' => ['required', 'string'],
        ];
    }


    public function attributes()
    {
        return [
            'breaking_news' =>'your post',
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
