<?php

namespace App\Http\Requests\Api;

use App\Enums\StatusType;
use App\Http\Traits\ApiResponser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class PostRequest extends FormRequest
{
    use ApiResponser;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->error($validator->errors()->first(), 422, $validator->errors()));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:500'],
            'image' => ['nullable', 'file', 'image'],
            'status' => ['required', 'string', Rule::in('draft', 'scheduled')],
            'scheduled_time' => ['required', 'string', 'date_format:Y-m-d H:i', 'after:today'],
            'platforms' => ['required', 'array'],
            'platforms.*' => ['required', 'exists:platforms,id'],
            'delete_image' => ['nullable', 'boolean'],
        ];
    }
}
