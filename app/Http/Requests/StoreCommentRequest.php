<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCommentRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Authorization logic if needed
    }

    public function rules()
    {
        return [
            'comment' => 'required|string|max:255',
        ];
    }
}
