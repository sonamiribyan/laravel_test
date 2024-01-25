<?php

namespace App\Http\Requests\Demo;

use Illuminate\Foundation\Http\FormRequest;

class DemoTestStoreRequest extends FormRequest
{
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
            'demo' => 'required|array|max:2000',
            'demo.*' => 'required|array', // Each element of 'demo' must be an array (object).
            'demo.*.ref' => 'required|string',
            'demo.*.name' => 'required|string',
            'demo.*.description' => 'nullable|string',
        ];
    }
}
