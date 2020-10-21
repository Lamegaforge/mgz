@inject('mediaService', 'App\Services\MediaService')

@extends('app')
@section('content')
<section class="relative overflow-hidden">
    <img class="absolute top-0 left-0 object-cover object-center w-full h-full blur" src="{{$mediaService->background($card->slug)}}" />
    <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-25"></div>
    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        @include('layouts.breadcrumbs', [
        'breadcrumbs' => [
        ['Home', route('home')],
        ['Fiches', route('cards.index')],
        $card->title]
        ])
    </div>
    <div class="px-4 py-16 mx-auto -mt-6 max-w-7xl sm:px-6 lg:px-8 md:py-20 lg:py-24">
        <div class="flex flex-col items-center space-y-6 md:flex-row md:space-y-0 md:space-x-12">
            <div class="w-full max-w-sm">
                <div class="relative shadow-md pt-2/3">
                    <img class="absolute top-0 left-0 object-cover object-center w-full h-full rounded" src="{{$mediaService->vignette($card->slug)}}" />
                </div>
            </div>
            <div class="relative flex-grow max-w-xl md:w-auto">
                <h1 class="text-4xl font-extrabold leading-10 text-white">{{$card->title}}</h1>
                <p class="font-semibold">{{$countClips}} clips</p>
                <p class="mt-3 text-gray-400 md:text-lg">{{$card->description}}</p>
            </div>
        </div>
    </div>
</section>
<section class="px-4 py-16 mx-auto sm:px-6 lg:px-8 md:py-20 lg:py-24 max-w-7xl">
    <h2 class="text-3xl font-light leading-8 tracking-tight text-white sm:text-3xl sm:leading-9">Meilleurs clips</h2>
    <div class="mt-6">
        @if(count($clips) > 0)
        <carousel :items="{{json_encode($clips)}}" :options="{responsive: [{end: 640, size: 1}, {start: 640, end: 768, size: 2}, {start: 768, end: 1024, size: 3},{size: 4}]}">
            @verbatim
            <template #default="{item}">
                <clip :item="item" />
            </template>
            @endverbatim
        </carousel>
        @else
        <p class="text-center">Pas encore de clips 🦕</p>
        @endif
    </div>
    <h2 class="mt-24 text-3xl font-light leading-8 tracking-tight text-white sm:text-3xl sm:leading-9">Tous les clips</h2>
    <grid grid-class="grid mt-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10" :card-id="{{$card->id}}" fetch-url="{{route('api.clips.search')}}" type="clips" />
</section>
@endsection