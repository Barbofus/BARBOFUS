<?php

namespace App\Http\Livewire\Utils;

use App\Enums\LocaleEnum;
use Livewire\Component;

class LocaleDropdown extends Component
{
    public string $locale;

    public string $test;

    /**
     * @return void
     */
    public function mount()
    {
        $this->locale = app()->getLocale();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.utils.locale-dropdown');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function setLocale(string $locale)
    {
        // Vérifie que la langue est prise en compte par le site
        if (! in_array($locale, LocaleEnum::values(), true)) {
            return;
        }

        if (auth()->check()) {
            auth()->user()->update(['locale' => $locale]);
        } else {
            session()->put('locale', $locale);
        }

        $this->locale = $locale;
        app()->setLocale($locale);

        return redirect(request()->header('Referer'));
    }
}
