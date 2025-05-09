<?php

namespace App\Http\Requests;

use App\Enums\ItemCategorieEnum;
use App\Enums\ItemSubcategorieEnum;
use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StoreUpdateUnitySkinRequest extends FormRequest
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
            'regex:/^#?[a-f0-9]{6}$/i',
        ];

        $raceId = (int) $this->input('race_id');
        $gender = (int) $this->input('gender');

        $imageValidation = '';

        if (str_contains(url()->previous(), 'skinator')) {
            $imageValidation = 'required|image|max:250|dimensions:width=300,height=500';
        } else {
            $imageRequired = (str_ends_with(\Route::currentRouteName(), 'update')) ? 'nullable' : 'required';
            $imageValidation = $imageRequired.'|image|max:500|dimensions:max_width=500,max_height=650';
        }

        $headsData = json_decode(Storage::disk('local')->get('json/skinator/HeadsRoot.json'), true)['references']['RefIds'];

        /** @var array<int, array{rid: int, type: array<string, string>, data: array{id: int, skins: string, assetId: string, breed: int, gender: int, label: string, order: int, payable: int}}> $headsData */
        $validFaces = collect($headsData)
            ->pluck('data')
            ->filter(function ($item) use ($raceId, $gender) {
                return $item['breed'] === $raceId && $item['gender'] === $gender;
            })
            ->pluck('id')
            ->unique()
            ->values()
            ->all();

        return [
            'race_id' => 'required|integer|exists:races,dofus_id',
            'face' => [
                'required',
                'integer',
                Rule::in($validFaces),
            ],
            'image_path' => $imageValidation,
            'gender' => [
                'required',
                Rule::in([0, 1]),
            ],
            'name' => 'nullable|max:30',

            'g-recaptcha-response' => ['required', new Recaptcha],

            'color_skin' => $hexRegex,
            'color_hair' => $hexRegex,
            'color_cloth_1' => $hexRegex,
            'color_cloth_2' => $hexRegex,
            'color_cloth_3' => $hexRegex,
            'color_cloth_4' => $hexRegex,

            'hat_id' => [
                'nullable',
                'integer',
                Rule::exists('items', 'dofus_id')->where('category', ItemCategorieEnum::HAT->value),
            ],
            'cape_id' => [
                'nullable',
                'integer',
                Rule::exists('items', 'dofus_id')->where('category', ItemCategorieEnum::CAPE->value),
            ],
            'shield_id' => [
                'nullable',
                'integer',
                Rule::exists('items', 'dofus_id')->where('category', ItemCategorieEnum::SHIELD->value),
            ],
            'pet_id' => [
                'nullable',
                'integer',
                Rule::exists('items', 'dofus_id')->where('category', ItemCategorieEnum::PET->value),
            ],
            'costume_id' => [
                'nullable',
                'integer',
                Rule::exists('items', 'dofus_id')->where('category', ItemCategorieEnum::COSTUME->value),
            ],
            'wings_id' => [
                'nullable',
                'integer',
                Rule::exists('items', 'dofus_id')->where('category', ItemCategorieEnum::WINGS->value),
            ],
            'shoulderpads_id' => [
                'nullable',
                'integer',
                Rule::exists('items', 'dofus_id')->where('category', ItemCategorieEnum::SHOULDERPADS->value),
            ],
            'mount_id' => [
                'nullable',
                'integer',
                Rule::exists('items', 'dofus_id')
                    ->where('category', ItemCategorieEnum::PET->value)
                    ->where('subcategory', ItemSubcategorieEnum::MIMISYMBIC->value)
                    ->whereIn('pet_type', ['dragodinde', 'muldo', 'volkorne']),
            ],
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

            'color_skin.regex' => $hexMsg,
            'color_hair.regex' => $hexMsg,
            'color_cloth_1.regex' => $hexMsg,
            'color_cloth_2.regex' => $hexMsg,
            'color_cloth_3.regex' => $hexMsg,
            'color_cloth_4.regex' => $hexMsg,

            'hat_id' => 'Cette coiffe n\'éxiste pas.',
            'cape_id' => 'Cette cape n\'éxiste pas.',
            'shield_id' => 'Ce bouclier n\'éxiste pas.',
            'pet_id' => 'Ce familier n\'éxiste pas.',
            'costume_id' => 'Ce costume n\'éxiste pas.',
            'wings_id' => 'Ces ailes n\'éxistent pas.',
            'shoulderpads_id' => 'Ces épaulières n\'éxistent pas.',
            'mount_id' => 'Cette monture n\'éxiste pas.',

        ];
    }
}
