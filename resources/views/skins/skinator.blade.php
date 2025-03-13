@extends('layouts.basic-views')

@section('content')
    <h1 class="text-[min(4rem,15vw)] mt-10 font-normal text-center uppercase">{{ __('barbofus.titleSkinator') }}</h1>
    <h2 class="text-2xl font-thin text-center -mt-3 mb-8 uppercase">{{ __('barbofus.descriptionSkinator') }}</h2>

    <div class="flex flex-wrap gap-16 justify-center p-8">
        @foreach($items as $item)
            <div class="rounded-lg bg-primary-100 p-4 h-fit">
                <div class="flex h-16">
                    <img src="{{ asset('storage/' . $item->icon_path) }}" alt="">
                    <div>
                        <p class="italic text-inactiveText">{{ $item->name }}</p>
                        <div class="flex w-full justify-between">
                            <p class="font-medium">skin {{ $item->asset_id }}</p>
                            @if($item->category === 'costume')
                                <p class="font-medium">{{ $item->female_asset_id }}</p>
                            @endif
                        </div>
                        <p class="italic font-medium text-inactiveText">id {{ $item->dofus_id }}</p>
                    </div>
                </div>

                <a href="{{ asset('storage/images/skinator/'. $item->folder . '/' . $item->asset_id . '.png') }}" target="_blank">
                    <img src="{{ asset('storage/images/skinator/'. $item->folder . '/' . $item->asset_id . '.png') }}" alt="" class="w-48 mt-4 border-t border-inactiveText pt-4">
                </a>

                @if($item->category === 'costume')
                    <a href="{{ asset('storage/images/skinator/skins/' . $item->female_asset_id . '.png') }}" target="_blank">
                        <img src="{{ asset('storage/images/skinator/skins/' . $item->female_asset_id . '.png') }}" alt="" class="w-48 mt-4 border-t border-inactiveText pt-4">
                    </a>
                @endif
            </div>
        @endforeach
    </div>
@endsection
