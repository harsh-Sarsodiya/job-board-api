<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'job_id' => ['required', 'exists:jobs,id'],
            'message' => ['nullable', 'string'],
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
        ];
    }
}
