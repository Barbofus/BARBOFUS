<?php

namespace App\Http\Livewire\Skin;

use App\Actions\Likes\SwitchLikes;
use App\Models\Like;
use App\Models\Skin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SkinIndexChunk extends Component
{
    public $skinIds;
    public $page;
    public $itemsPerPage;

    public function render()
    {
        $skins = Skin::select('id', 'image_path', 'created_at', 'gender', 'race_id', 'user_id', 'dofus_item_hat_id', 'dofus_item_cloak_id', 'dofus_item_shield_id', 'dofus_item_pet_id', 'dofus_item_costume_id')
            ->addSelect([
                'user_name' => User::select('name')
                    ->whereColumn('id', 'skins.user_id')
                    ->take(1)
            ])
            ->addSelect([
                'is_liked' => Like::select('id')
                    ->whereColumn('skin_id', 'skins.id')
                    ->where('user_id', Auth::id())
                    ->take(1)
            ])
            ->with( 'Rewards:id,skin_id,points', 'Race:name,id',
                'DofusItemHat:id,name,dofus_items_sub_categorie_id', 'DofusItemHat.DofusItemsSubCategorie',
                'DofusItemCloak:id,name,dofus_items_sub_categorie_id', 'DofusItemCloak.DofusItemsSubCategorie',
                'DofusItemShield:id,name,dofus_items_sub_categorie_id', 'DofusItemShield.DofusItemsSubCategorie',
                'DofusItemPet:id,name,dofus_items_sub_categorie_id', 'DofusItemPet.DofusItemsSubCategorie',
                'DofusItemCostume:id,name,dofus_items_sub_categorie_id', 'DofusItemCostume.DofusItemsSubCategorie')
            ->withCount('Likes')
            ->find($this->skinIds)
            ->keyBy('id');

        $orderedSkins = collect($this->skinIds)->map(fn ($id) => $skins[$id]);

        return view('livewire.skin.skin-index-chunk', [
            'skins' => $orderedSkins,
        ]);
    }

    public function SwitchHeart($skin)
    {
        (new SwitchLikes)($skin);
    }
}
