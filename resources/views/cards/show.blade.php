@extends('app')
@section('content')
<section class="relative overflow-hidden">
    <img class="absolute top-0 left-0 object-cover object-center w-full h-full blur" src="https://steamcdn-a.akamaihd.net/steam/apps/242760/ss_e50b7c8bc2f4720859ba13aa32703661192f4d62.1920x1080.jpg?t=1590522045" />
    <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-25"></div>
    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        @include('layouts.breadcrumbs', [
        'breadcrumbs' => ['Home',
        'Fiches',
        $card->title]
        ])
    </div>
    <div class="px-4 py-16 mx-auto -mt-6 max-w-7xl sm:px-6 lg:px-8 md:py-20 lg:py-24">
        <div class="flex flex-col items-center space-y-6 md:flex-row md:space-y-0 md:space-x-12">
            <div class="w-full max-w-sm">
                <div class="relative shadow-md pt-3/4">
                    <img class="absolute top-0 left-0 object-cover object-center w-full h-full rounded" src="@cardLogo($card->media_folder)" />
                </div>
            </div>
            <div class="relative flex-grow max-w-xl md:w-auto">
                <h1 class="text-4xl font-extrabold leading-10 text-white">{{$card->title}}</h1>
                <p class="font-semibold">12 clips</p>
                <p class="mt-3 text-gray-400 md:text-lg">{{$card->description}}</p>
            </div>
        </div>
    </div>
</section>
<section class="px-4 py-16 mx-auto sm:px-6 lg:px-8 md:py-20 lg:py-24 max-w-7xl">
    <h2 class="text-3xl font-light leading-8 tracking-tight text-white sm:text-3xl sm:leading-9">Meilleurs clips</h2>
    <div class="grid grid-cols-1 gap-8 mt-6 sm:grid-cols-2 md:grid-cols-3">

    </div>
    <h2 class="mt-24 text-3xl font-light leading-8 tracking-tight text-white sm:text-3xl sm:leading-9">Tous les clips</h2>
    <grid grid-class="grid mt-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10" :card-id="{{$card->id}}" fetch-url="{{route('api.clips.search')}}" type="clips" />
</section>
@endsection