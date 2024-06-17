<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'max:2000',
        ];
    }

    /**
     * Sanitize input before validation
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge(
            [
                'slug' => Str::slug($this->slug)
            ]
        );
    }
}
