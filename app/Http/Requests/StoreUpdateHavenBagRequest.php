<?php

namespace App\Http\Requests;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateHavenBagRequest extends FormRequest
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
        $imageRequired = (str_ends_with(\Route::currentRouteName(), 'update')) ? 'nullable' : 'required';

        return [
            'haven_bag_theme_id' => 'required|integer|exists:haven_bag_themes,id',
            'image_path' => $imageRequired.'|image|max:10000|dimensions:min_width=1200,min_height=650',
            'name' => 'nullable|max:30',

            'g-recaptcha-response' => ['required', new Recaptcha],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'image_path.dimensions' => "L'image doit être supèrieur à :min_widthx:min_height pixels.",
            'image_path.max' => "L'image ne doit pas dépasser :max ko.",

        ];
    }
}
