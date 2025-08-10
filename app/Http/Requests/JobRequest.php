<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'type' => ['required', 'in:full-time,part-time,contract,freelance,internship'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'expiration_date' => ['required', 'date', 'after:today'],
        ];
    }
}
