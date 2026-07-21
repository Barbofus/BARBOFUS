<?php

declare(strict_types=1);

namespace App\Actions\ItemsUpdate;

use App\Enums\ItemCategorieEnum;
use App\Enums\ItemSubcategorieEnum;
use App\Enums\WeaponSubcategorieEnum;
use App\Models\Item;
use App\Models\LocalizedItem;
use App\Models\LocalizedRace;
use App\Models\Race;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\VarDumper;

final class updateDBFromDofusFiles
{
    /**
     * @var array<int, mixed>
     */
    private array $newItems = [];

    /**
     * @var array<int, mixed>
     */
    private array $icons = [];

    /**
     * @var array<string, array<int, string>>
     */
    private array $langData = [];

    /**
     * @var array<int, mixed>
     */
    private array $typeID = [];

    /**
     * @return array<string, array<int, mixed>>
     */
    public function __invoke(): array
    {
        $langs = ['fr', 'en', 'es', 'pt'];

        $this->typeID = [
            16  => ['cat' => ItemCategorieEnum::HAT->value,             'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Chapeau
            246 => ['cat' => ItemCategorieEnum::HAT->value,             'subcat' => ItemSubcategorieEnum::CEREMONIAL->value],   // Chapeau d'apparat

            17  => ['cat' => ItemCategorieEnum::CAPE->value,            'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Cape
            247 => ['cat' => ItemCategorieEnum::CAPE->value,            'subcat' => ItemSubcategorieEnum::CEREMONIAL->value],   // Cape d'apparat

            82  => ['cat' => ItemCategorieEnum::SHIELD->value,          'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Bouclier
            248 => ['cat' => ItemCategorieEnum::SHIELD->value,          'subcat' => ItemSubcategorieEnum::CEREMONIAL->value],   // Bouclier d'apparat

            199 => ['cat' => ItemCategorieEnum::COSTUME->value,         'subcat' => ItemSubcategorieEnum::CEREMONIAL->value],   // Costume
            299 => ['cat' => ItemCategorieEnum::SHOULDERPADS->value,    'subcat' => ItemSubcategorieEnum::CEREMONIAL->value],   // Épaulière
            300 => ['cat' => ItemCategorieEnum::WINGS->value,           'subcat' => ItemSubcategorieEnum::CEREMONIAL->value],   // Ailes

            18  => ['cat' => ItemCategorieEnum::PET->value,             'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Familier
            121 => ['cat' => ItemCategorieEnum::PET->value,             'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Montilier
            311 => ['cat' => ItemCategorieEnum::PET->value,             'subcat' => ItemSubcategorieEnum::CEREMONIAL->value],   // Monture
            324 => ['cat' => ItemCategorieEnum::PET->value,             'subcat' => ItemSubcategorieEnum::CEREMONIAL->value],   // Monture d'apparat
            249 => ['cat' => ItemCategorieEnum::PET->value,             'subcat' => ItemSubcategorieEnum::CEREMONIAL->value],   // Familier d'apparat
            250 => ['cat' => ItemCategorieEnum::PET->value,             'subcat' => ItemSubcategorieEnum::CEREMONIAL->value],   // Montilier d'apparat

            2   => ['cat' => ItemCategorieEnum::WEAPON->value,          'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Arc
            3   => ['cat' => ItemCategorieEnum::WEAPON->value,          'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Baguette
            4   => ['cat' => ItemCategorieEnum::WEAPON->value,          'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Bâton
            5   => ['cat' => ItemCategorieEnum::WEAPON->value,          'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Dague
            6   => ['cat' => ItemCategorieEnum::WEAPON->value,          'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Épée
            7   => ['cat' => ItemCategorieEnum::WEAPON->value,          'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Marteau
            8   => ['cat' => ItemCategorieEnum::WEAPON->value,          'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Pelle
            19  => ['cat' => ItemCategorieEnum::WEAPON->value,          'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Hache
            20  => ['cat' => ItemCategorieEnum::WEAPON->value,          'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Outil
            21  => ['cat' => ItemCategorieEnum::WEAPON->value,          'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Pioche
            22  => ['cat' => ItemCategorieEnum::WEAPON->value,          'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Faux
            114 => ['cat' => ItemCategorieEnum::WEAPON->value,          'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Arme magique
            271 => ['cat' => ItemCategorieEnum::WEAPON->value,          'subcat' => ItemSubcategorieEnum::MIMISYMBIC->value],   // Lance
            251 => ['cat' => ItemCategorieEnum::WEAPON->value,          'subcat' => ItemSubcategorieEnum::CEREMONIAL->value],   // Arme d'apparat
        ];

        foreach ($langs as $lang) {
            $langFile = storage_path('app/json/skinator/lang/') . $lang . '.json';
            // @phpstan-ignore-next-line
            $this->langData[$lang] = json_decode(file_get_contents($langFile), true);
        }

        $this->updateBreeds();
        $this->updateItems();
        $this->updateLivingObjects();
        $this->updateMounts();

        return [
            'newItems' => $this->newItems,
            'icons' => $this->icons,
        ];
    }

    public function updateWeapons(): void {}

    public function updateMounts(): void
    {
        $mountsData = json_decode(Storage::disk('local')->get('json/skinator/MountsDataRoot.json'), true)['references']['RefIds'];
        $itemsData = json_decode(Storage::disk('local')->get('json/skinator/ItemsDataRoot.json'), true)['references']['RefIds'];

        $allItems = Item::all()->keyBy('dofus_id');
        $allItemsName = LocalizedItem::all()->groupBy(fn($item) => $item->dofus_id . '|' . $item->locale);

        foreach ($mountsData as $mount) {
            $mountD = $mount['data'];

            if (! isset($mountD['familyId'])) {
                return;
            }

            $item = null;
            foreach ($itemsData as $id) {
                if (($id['data']['id'] ?? null) === $mountD['certificateId']) {
                    $item = $id['data'] ?? null;
                    break;
                }
            }

            $petType = null;

            switch ($item['typeId']) {
                case 97:
                    $petType = 'dragodinde';
                    break;
                case 196:
                    $petType = 'muldo';
                    break;
                case 207:
                    $petType = 'volkorne';
                    break;
            }

            $value = [
                'dofus_id' => $mountD['certificateId'],
                'folder' => 'bones',
                'level' => 60,
                'category' => ItemCategorieEnum::PET->value,
                'subcategory' => ItemSubcategorieEnum::MIMISYMBIC->value,
                'pet_type' => $petType,
                'icon_path' => 'images/icons/items/' . $item['iconId'] . '.webp',
                'colorable' => $item['isColorable'],
                'asset_id' => $mountD['id'],
                'female_asset_id' => $mountD['id'],
            ];

            $names = [];

            foreach ($this->langData as $lang => $translation) {
                $names[$lang] = $translation[$item['nameId']] ?? "no translation yet";
            }

            $this->icons[] = $item['iconId'];

            $existingItem = $allItems[$item['id']] ?? null;
            if (! $existingItem) {
                $this->newItems[] = $value + ['name' => $names['fr'] ?? 'Nom inconnu'];
                Item::create($value);
            } elseif (array_diff_assoc($value, $existingItem->toArray())) {
                $existingItem->update($value);
            }

            foreach ($this->langData as $lang => $translation) {
                $existingItemName = $allItemsName[$item['id'] . '|' . $lang][0] ?? null;
                if (! $existingItemName) {
                    LocalizedItem::create([
                        'dofus_id' => $item['id'],
                        'locale' => $lang,
                        'name' => $names[$lang],
                    ]);
                } elseif ($existingItemName->name != $names[$lang]) {
                    $existingItemName->update(['name' => $names[$lang]]);
                }
            }
        }
    }

    public function updateLivingObjects(): void
    {
        $itemsData = json_decode(Storage::disk('local')->get('json/skinator/ItemsDataRoot.json'), true)['references']['RefIds'];
        $livingData = json_decode(Storage::disk('local')->get('json/skinator/LivingObjectSkinsMoodsDataRoot.json'), true)['references']['RefIds'];

        if (json_last_error() !== JSON_ERROR_NONE) {
            dd('erreur json : ' . json_last_error_msg());
        }

        $allItems = Item::all()->keyBy('dofus_id');
        $allItemsName = LocalizedItem::all()->groupBy(fn($item) => $item->dofus_id . '|' . $item->locale);

        // Indexe les items par leur ID pour un accès rapide
        $itemsById = [];
        foreach ($itemsData as $item) {
            if (isset($item['rid'])) {
                $itemsById[$item['rid']] = $item['data'] ?? [];
            }
        }

        // Récupère les items objets vivants
        $skinIds = array_map(function ($item) {
            return $item['data']['skinId'] ?? null;
        }, $livingData);

        // On enlève les null au passage
        $skinIds = array_filter($skinIds);

        // Filtre les items correspondants
        $itemsLivingData = array_filter(
            $itemsData,
            fn($item) => isset($item['data']['id']) && in_array($item['data']['id'], $skinIds)
        );

        // On garde seulement ceux avec effets utiles
        $usefulLiving = array_values(array_filter(array_map(function ($item) use ($itemsById) {
            foreach ($item['data']['possibleEffects'] ?? [] as $effect) {
                if (isset($effect['rid'], $itemsById[$effect['rid']]['value'])) {
                    $effectValue = $itemsById[$effect['rid']]['value'];
                    if (array_key_exists($effectValue, $this->typeID)) {
                        $item['data']['usefulLivingEffect'] = $effectValue; // Ajoute la valeur utile

                        return $item;
                    }
                }
            }

            return null;
        }, $itemsLivingData)));

        foreach ($usefulLiving as $item) {
            $itemD = $item['data'];
            $petType = null;

            if ($itemD['typeId'] == 324) {
                $name_fr = $this->langData['fr'][$itemD['nameId']] ?? '';
                $name_lower = strtolower($name_fr);
                if (str_contains($name_lower, 'volkorne')) {
                    $petType = 'volkorne';
                } elseif (str_contains($name_lower, 'muldo') || str_contains($name_lower, 'moldus')) {
                    $petType = 'muldo';
                } elseif (str_contains($name_lower, 'dragodinde') || str_contains($name_lower, 'drago') || str_contains($name_lower, 'dinde')) {
                    $petType = 'dragodinde';
                }
            } else {
                switch ($itemD['typeId']) {
                    case 190:
                        $petType = 'dragodinde';
                        break;
                    case 255:
                        $petType = 'muldo';
                        break;
                    case 256:
                        $petType = 'volkorne';
                        break;
                    case 18:
                    case 249:
                        $petType = 'familier';
                        break;
                    case 121:
                    case 250:
                        $petType = 'montilier';
                        break;
                }
            }

            $names = [];

            foreach ($this->langData as $lang => $translation) {
                $names[$lang] = $translation[$itemD['nameId']] ?? "no translation yet";
            }

            $currentLV = null;
            foreach ($livingData as $ld) {
                if (($ld['data']['skinId'] ?? null) === $itemD['id']) {
                    $currentLV = $ld['data']['moods'][1]['values'] ?? null;
                    break;
                }
            }

            foreach ($currentLV as $key => $lv) {
                $dofusId = (1000000000 + ($itemD['id'] * 1000) + ($key + 1));
                $value = [
                    'dofus_id' => $dofusId,
                    'folder' => in_array($itemD['typeId'], [18, 249, 121, 250]) ? 'bones' : 'skins',
                    'level' => $itemD['level'],
                    'category' => $this->typeID[$itemD['usefulLivingEffect']]['cat'],
                    'subcategory' => ItemSubcategorieEnum::LIVINGOBJECT->value,
                    'pet_type' => $petType,
                    'icon_path' => 'images/icons/items/' . $lv . '.webp',
                    'colorable' => $itemD['isColorable'],
                ];

                $this->icons[] = $lv;

                $existingItem = $allItems[$dofusId] ?? null;
                if (! $existingItem) {
                    $this->newItems[] = $value + ['name' => ($names['fr'] . ' ' . ($key + 1))];
                    Item::create($value);
                } elseif (array_diff_assoc($value, $existingItem->toArray())) {
                    $existingItem->update($value);
                }

                foreach ($this->langData as $lang => $translation) {
                    $existingItemName = $allItemsName[$dofusId . '|' . $lang][0] ?? null;
                    if (! $existingItemName) {
                        LocalizedItem::create([
                            'dofus_id' => $dofusId,
                            'locale' => $lang,
                            'name' => $names[$lang] . ' ' . ($key + 1),
                        ]);
                    } elseif ($existingItemName->name != $names[$lang]) {
                        $existingItemName->update(['name' => $names[$lang] . ' ' . ($key + 1)]);
                    }
                }
            }
        }
    }

    public function updateItems(): void
    {

        $itemsData = json_decode(Storage::disk('local')->get('json/skinator/ItemsDataRoot.json'), true)['references']['RefIds'];

        if (json_last_error() !== JSON_ERROR_NONE) {
            dd('erreur json : ' . json_last_error_msg());
        }

        $itemsData = array_filter($itemsData, function ($item) {
            return isset($item['data']['typeId']) && isset($this->typeID[$item['data']['typeId']]);
        });

        // Indexe les items par leur ID pour un accès rapide
        $itemsByRid = [];
        foreach ($itemsData as $item) {
            if (isset($item['rid'])) {
                $itemsByRid[$item['rid']] = $item['data'] ?? [];
            }
        }

        $allItems = Item::all()->keyBy('dofus_id');
        $allItemsName = LocalizedItem::all()->groupBy(fn($item) => $item->dofus_id . '|' . $item->locale);

        $weaponData = [];

        foreach ($itemsData as $item) {
            $itemD = $item['data'];

            if ($item['type']['class'] === "WeaponData") $weaponData[] = $itemD;

            if (! isset($itemD['typeId'])) {
                continue;
            }

            if (! in_array($itemD['typeId'], array_keys($this->typeID))) {
                continue;
            }

            $weaponType = null;

            // if ($itemD['typeId'] === 251) {
            //     //dd($itemD, $itemsData);
            //     foreach ($itemD['possibleEffects'] ?? [] as $effect) {
            //         if (isset($effect['rid'], $itemsByRid[$effect['rid']]['value'])) {
            //             $effectValue = $itemsByRid[$effect['rid']]['value'];
            //             dd($itemD, $effect, $effectValue);
            //             if (array_key_exists($effectValue, $this->typeID)) {
            //                 $item['data']['usefulLivingEffect'] = $effectValue;
            //             }
            //         }
            //     }
            // }

            switch ($itemD['typeId']) {
                case 2:
                    $weaponType = WeaponSubcategorieEnum::ARC->value;
                    break;
                case 3:
                    $weaponType = WeaponSubcategorieEnum::BAGUETTE->value;
                    break;
                case 4:
                    $weaponType = WeaponSubcategorieEnum::BATON->value;
                    break;
                case 5:
                    $weaponType = WeaponSubcategorieEnum::DAGUE->value;
                    break;
                case 6:
                    $weaponType = WeaponSubcategorieEnum::EPEE->value;
                    break;
                case 7:
                    $weaponType = WeaponSubcategorieEnum::MARTEAU->value;
                    break;
                case 8:
                    $weaponType = WeaponSubcategorieEnum::PELLE->value;
                    break;
                case 19:
                    $weaponType = WeaponSubcategorieEnum::HACHE->value;
                    break;
                case 20:
                    $weaponType = WeaponSubcategorieEnum::OUTIL->value;
                    break;
                case 21:
                    $weaponType = WeaponSubcategorieEnum::PIOCHE->value;
                    break;
                case 22:
                    $weaponType = WeaponSubcategorieEnum::FAUX->value;
                    break;
                case 114:
                    $weaponType = WeaponSubcategorieEnum::ARME_MAGIQUE->value;
                    break;
                case 271:
                    $weaponType = WeaponSubcategorieEnum::LANCE->value;
                    break;
            }

            $petType = null;

            if ($itemD['typeId'] == 324) {
                $name_fr = $this->langData['fr'][$itemD['nameId']] ?? '';
                $name_lower = strtolower($name_fr);
                if (str_contains($name_lower, 'volkorne')) {
                    $petType = 'volkorne';
                } elseif (str_contains($name_lower, 'muldo') || str_contains($name_lower, 'moldus')) {
                    $petType = 'muldo';
                } elseif (str_contains($name_lower, 'dragodinde') || str_contains($name_lower, 'drago') || str_contains($name_lower, 'dinde')) {
                    $petType = 'dragodinde';
                }
            } else {
                switch ($itemD['typeId']) {
                    case 190:
                        $petType = 'dragodinde';
                        break;
                    case 255:
                        $petType = 'muldo';
                        break;
                    case 256:
                        $petType = 'volkorne';
                        break;
                    case 18:
                    case 249:
                        $petType = 'familier';
                        break;
                    case 121:
                    case 250:
                        $petType = 'montilier';
                        break;
                }
            }


            $value = [
                'dofus_id' => $itemD['id'],
                'folder' => in_array($itemD['typeId'], [18, 249, 121, 250]) ? 'bones' : 'skins',
                'level' => $itemD['level'],
                'category' => $this->typeID[$itemD['typeId']]['cat'],
                'subcategory' => $this->typeID[$itemD['typeId']]['subcat'],
                'pet_type' => $petType,
                'weapon_type' => $weaponType,
                'icon_path' => 'images/icons/items/' . $itemD['iconId'] . '.webp',
                'colorable' => $itemD['isColorable'],
            ];

            $this->icons[] = $itemD['iconId'];

            $names = [];

            foreach ($this->langData as $lang => $translation) {
                $names[$lang] = $translation[$itemD['nameId']] ?? "no translation yet";
            }

            $existingItem = $allItems[$itemD['id']] ?? null;
            if (! $existingItem) {
                $this->newItems[] = $value + ['name' => $names['fr'] ?? 'Nom inconnu'];
                Item::create($value);
            } elseif (array_diff_assoc($value, $existingItem->toArray())) {
                $existingItem->update($value);
            }

            foreach ($this->langData as $lang => $translation) {
                $existingItemName = $allItemsName[$itemD['id'] . '|' . $lang][0] ?? null;
                if (! $existingItemName) {
                    LocalizedItem::create([
                        'dofus_id' => $itemD['id'],
                        'locale' => $lang,
                        'name' => $names[$lang],
                    ]);
                } elseif ($existingItemName->name != $names[$lang]) {
                    $existingItemName->update(['name' => $names[$lang]]);
                }
            }
        }
        //dd($weaponData[0]);
    }

    public function updateBreeds(): void
    {
        $breedsData = json_decode(Storage::disk('local')->get('json/skinator/BreedsDataRoot.json'), true)['references']['RefIds'];
        $headsData = json_decode(Storage::disk('local')->get('json/skinator/HeadsDataRoot.json'), true)['references']['RefIds'];
        $bodiesData = json_decode(Storage::disk('local')->get('json/skinator/BodiesDataRoot.json'), true)['references']['RefIds'];

        $allBreeds = Race::all();
        $allBreedsName = LocalizedRace::all();

        $headsByBreed = [];
        $bodiesByBreed = [];

        // Récupère les têtes
        foreach ($headsData as $head) {
            $headD = $head['data'];
            if (! isset($headsByBreed[$headD['breed']])) {
                $headsByBreed[$headD['breed']] = [];
            }
            $headsByBreed[$headD['breed']][$headD['gender'] ? 'female' : 'male'][$headD['order']] = [
                'id' => $headD['id'],
                'skins' => $headD['skins'],
                'assetId' => $headD['assetId'],
            ];
        }

        // Récupère les corps
        foreach ($bodiesData as $body) {
            $bodyD = $body['data'];
            if (! isset($bodiesByBreed[$bodyD['breed']])) {
                $bodiesByBreed[$bodyD['breed']] = [];
            }
            $bodiesByBreed[$bodyD['breed']][$bodyD['gender'] ? 'female' : 'male'][$bodyD['order']] = [
                'id' => $bodyD['id'],
                'skins' => $bodyD['skins'],
                'assetId' => $bodyD['assetId'],
            ];
        }

        foreach ($breedsData as $breedData) {
            $breed = $breedData['data'];

            // Récupérer les couleurs
            $colorsArray = [
                'male' => $breed['maleColors'],
                'female' => $breed['femaleColors'],
            ];

            // Préparer les têtes
            $headsArray = isset($headsByBreed[$breed['id']]) ? $headsByBreed[$breed['id']] : [];

            // Préparer les corps
            $bodiesArray = isset($bodiesByBreed[$breed['id']]) ? $bodiesByBreed[$breed['id']] : [];

            // Structurer les données à insérer ou mettre à jour
            $value = [
                'name' => $this->langData['fr'][$breed['shortNameId']],
                'colors' => json_encode($colorsArray),
                'heads' => json_encode($headsArray),
                'bodies' => json_encode($bodiesArray),
                'ghost_icon_path' => 'images/icons/classes/ghost/' . $breed['id'] . '.png',
                'colored_icon_path' => 'images/icons/classes/colored/' . $breed['id'] . '.png',
                'dofus_id' => $breed['id'],
            ];

            // Vérifier si la classe existe déjà pour la mettre à jour ou la créer
            $existingBreed = $allBreeds->where('dofus_id', $breed['id'])->first();
            if (! $existingBreed) {
                Race::create($value);
            } else {
                $existingBreed->update($value);
            }

            // Met à jour les traductions
            foreach ($this->langData as $lang => $translation) {
                $existingBreedName = $allBreedsName->where('dofus_id', $breed['id'])->where('locale', $lang)->first();
                if (! $existingBreedName) {
                    LocalizedRace::create([
                        'dofus_id' => $breed['id'],
                        'locale' => $lang,
                        'name' => $translation[$breed['shortNameId']],
                    ]);
                } else {
                    $existingBreedName->update(['name' => $translation[$breed['shortNameId']]]);
                }
            }
        }
    }
}
