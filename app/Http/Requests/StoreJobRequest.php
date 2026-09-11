<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
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
                    'employer_id' => [
            'required', \Illuminate\Validation\Rule::exists('employers', 'employer_id')],
            'job_title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'nullable|numeric|min:0',
            'location' => 'required|string|max:255',
            'deadline' => 'required|date|after:today', // تاریخ انقضا باید برای آینده باشد
        ];
    }
}
