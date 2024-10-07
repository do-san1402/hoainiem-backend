<?php

namespace Modules\Setting\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class SpaceCredentialRequest extends FormRequest
{
    use FormRequestTrait;

    /**
     * Space Credential id
     *
     * @var int|null
     */
    private ?int $spaceCredentialId;

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
            'key'    => ['required', 'string'],
            'secret' => ['required', 'string'],
            'region' => ['required', 'string'],
            'bucket' => ['required', 'string'],
            'url'    => ['nullable', 'string'],
        ];

    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->spaceCredentialId = $this->route('language');
    }

}
