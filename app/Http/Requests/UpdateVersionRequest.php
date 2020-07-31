<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVersionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'display_name' => 'required|string|min:3|max:150',
            'color' => 'nullable|string|min:3|max:150',
            'color_code' => 'nullable|string|min:7|max:9',
            'price' => 'nullable',
            'is_active' => 'required|boolean',
            'image_id' => 'nullable|numeric'
        ];
    }
}
