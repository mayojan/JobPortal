<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // تغییر دادن false به true
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'job_title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'salary' => 'sometimes|nullable|numeric|min:0',
            'location' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:full-time,part-time,remote,contract'
        ];
    }
}
