<?php

namespace App\Http\Requests;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateSkinRequest extends FormRequest
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
        $hexRegex = [
            'required',
            'regex:/^[a-f0-9]{6}$/i',
        ];

        $imageRequired = (str_ends_with(\Route::currentRouteName(), 'update')) ? 'nullable' : 'required';

        return [
            'race_id' => 'required|integer|exists:races,id',
            'face' => 'required|integer|between:1,8',
            'image_path' => $imageRequired.'|image|max:100|dimensions:max_width=350,max_height=450',
            'gender' => [
                'required',
                Rule::in(['Homme', 'Femme']),
            ],
            'g-recaptcha-response' => ['required', new Recaptcha()],

            'color_skin' => $hexRegex,
            'color_hair' => $hexRegex,
            'color_cloth_1' => $hexRegex,
            'color_cloth_2' => $hexRegex,
            'color_cloth_3' => $hexRegex,

            'dofus_item_hat_id' => 'nullable|integer|exists:dofus_item_hats,id',
            'dofus_item_cloak_id' => 'nullable|integer|exists:dofus_item_cloaks,id',
            'dofus_item_shield_id' => 'nullable|integer|exists:dofus_item_shields,id',
            'dofus_item_pet_id' => 'nullable|integer|exists:dofus_item_pets,id',
            'dofus_item_costume_id' => 'nullable|integer|exists:dofus_item_costumes,id',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages()
    {
        $hexMsg = 'Code hexadécimal requis.';
        $itemsMsg = 'Cet item n\'éxiste pas.';

        return [
            'image_path.dimensions' => "L'image doit être inférieur à :max_widthx:max_height pixels.",
            'image_path.max' => "L'image ne doit pas dépasser :max ko.",

            'color_skin.regex' => $hexMsg,
            'color_hair.regex' => $hexMsg,
            'color_cloth_1.regex' => $hexMsg,
            'color_cloth_2.regex' => $hexMsg,
            'color_cloth_3.regex' => $hexMsg,

            'dofus_item_hat_id' => $itemsMsg,
            'dofus_item_cloak_id' => $itemsMsg,
            'dofus_item_shield_id' => $itemsMsg,
            'dofus_item_pet_id' => $itemsMsg,
            'dofus_item_costume_id' => $itemsMsg,

        ];
    }
}
