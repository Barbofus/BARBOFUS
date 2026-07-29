<?php

namespace App\Http\Livewire\Forms;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class SkinFilterSearchBar extends Component
{
    /**
     * @var array<int, string>
     */
    public $searchFilterInput;

    public int $selectionKey = 0;

    public string $query = '';

    public string $oldQuery = '';

    public mixed $itemToShow = [];

    public mixed $itemResults = [];

    /**
     * @var string[]
     */
    protected $listeners = [
        'ToggleSearchedText' => 'emptyQuery',
    ];

    /**
     * @return View
     */
    public function render()
    {
        $this->findForItems($this->query);
        $this->getResults();

        return view('livewire.forms.skin-filter-search-bar');
    }

    /**
     * @return void
     */
    private function getResults()
    {
        $this->itemResults = [];

        foreach ($this->searchFilterInput as $key => $value) {

            $id = substr($value, 1);

            if ($value[0] == '0') {
                $this->itemResults[] = [
                    $value,
                    optional(DB::table('items')
                        ->select('dofus_id')
                        ->where('items.dofus_id', $id)
                        ->addSelect([
                            'name' => DB::table('localized_items')
                                ->select('name')
                                ->where('dofus_id', $id)
                                ->where('locale', app()->getLocale())
                                ->take(1),
                        ])->first())->name,
                ];
            } else {
                $this->itemResults[] = [
                    $value,
                    optional(DB::table('users')
                        ->select('name')
                        ->where('id', $id)->first())->name,
                ];
            }
        }
    }

    /**
     * @return void
     */
    public function findForItems(string $query)
    {

        $this->itemToShow = [];

        if ($this->oldQuery != $this->query) {
            $this->selectionKey = 0;
        }

        if (strlen($query) < 3) {
            return;
        }

        $this->itemToShow = array_merge(DB::table('users')
            ->select('id', 'name')
            ->where('name', 'LIKE', '%'.$query.'%')
            ->addSelect([DB::raw('1 as is_user')])
            ->get()
            ->toArray());

        $this->itemToShow = array_merge(DB::table('items')
            ->select('items.dofus_id as id', 'items.icon_path', 'localized_items.name')
            ->leftJoin('localized_items', function ($join) use ($query) {
                $join->on('localized_items.dofus_id', '=', 'items.dofus_id')
                    ->where('localized_items.locale', app()->getLocale())
                    ->where('localized_items.name', 'like', '%'.$query.'%');
            })
            ->whereNotNull('localized_items.name')
            ->addSelect([DB::raw('0 as is_user')])
            ->get()
            ->toArray(), $this->itemToShow);

        usort($this->itemToShow, function ($a, $b) {
            if ($a->is_user != $b->is_user) {
                return $a->is_user <=> $b->is_user; // Users d'abord
            }

            return strcasecmp($a->name, $b->name); // Puis tri alphabétique
        });

        $this->itemToShow = array_values($this->itemToShow);

        $this->oldQuery = $query;

        $this->itemToShow = collect($this->itemToShow)->map(function ($item) {
            return (array) $item;
        })->toArray();
    }

    /**
     * @return void
     */
    public function emptyQuery()
    {
        $this->query = '';
        $this->itemToShow = [];
    }

    /**
     * @return void
     */
    public function incrementSelection()
    {

        $this->selectionKey++;

        if ($this->selectionKey > count($this->itemToShow) - 1) {
            $this->selectionKey = 0;
        }
    }

    /**
     * @return void
     */
    public function decrementSelection()
    {

        $this->selectionKey--;

        if ($this->selectionKey < 0) {
            $this->selectionKey = count($this->itemToShow) - 1;
        }
    }
}
