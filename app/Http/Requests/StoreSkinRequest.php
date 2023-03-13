<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkinRequest extends FormRequest
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
            'race_id' => 'required',
            'face' => 'required',
            'image_path' => 'image|required|max:100|dimensions:max_width=350,max_height=450',
            'gender' => 'required',
            'color_skin' => 'required',
            'color_hair' => 'required',
            'color_cloth_1' => 'required',
            'color_cloth_2' => 'required',
            'color_cloth_3' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'image_path.dimensions' => "L'image doit être inférieur à :max_widthx:max_height pixels.",
            'image_path.max' => "L'image ne doit pas dépasser :max ko",
        ];
    }
}
