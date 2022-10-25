<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'id' =>  request()->path() === 'edit-product' ? 'required' : '',
            'name' => 'required|string|min:2|max:25',
            "price" => 'required|regex:/^[0-9](\.[0-9][0-9][0-9])$/',
            'category_id' => 'required',
        ];
    }

   }

