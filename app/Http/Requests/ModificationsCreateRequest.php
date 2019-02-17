<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModificationsCreateRequest extends FormRequest
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
            'photo' => 'required|image|max:5120',
            'description' => 'required|min:5|max:450',
            'condition' => 'required|in:0,1',
            'is_sold' => 'required|in:0,1',
            'price' => 'required|numeric'
        ];
    }
}
