<?php

namespace App\Http\Requests;

use App\Models\DofusItemCloak;
use App\Models\DofusItemCostume;
use App\Models\DofusItemHat;
use App\Models\DofusItemPet;
use App\Models\DofusItemShield;
use App\Models\Race;
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
        $hexRegex =  [
            'required',
            'regex:/^[a-f0-9]{6}$/i'
        ];

        $imageRequired = (str_ends_with(\Route::currentRouteName(), 'update')) ? 'nullable' : 'required';

        return [
            'race_id' => 'required|integer|between:1,'.Race::all()->count(),
            'face' => 'required|integer|between:1,8',
            'image_path' => $imageRequired . '|image|max:100|dimensions:max_width=350,max_height=450',
            'gender' => [
                'required',
                Rule::in(['Homme', 'Femme']),
             ],

            'color_skin' => $hexRegex,
            'color_hair' => $hexRegex,
            'color_cloth_1' => $hexRegex,
            'color_cloth_2' => $hexRegex,
            'color_cloth_3' => $hexRegex,

            'dofus_item_hat_id' => 'nullable|integer|between:1,'.DofusItemHat::all()->count(),
            'dofus_item_cloak_id' => 'nullable|integer|between:1,'.DofusItemCloak::all()->count(),
            'dofus_item_shield_id' => 'nullable|integer|between:1,'.DofusItemShield::all()->count(),
            'dofus_item_pet_id' => 'nullable|integer|between:1,'.DofusItemPet::all()->count(),
            'dofus_item_costume_id' => 'nullable|integer|between:1,'.DofusItemCostume::all()->count(),
        ];
    }

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
