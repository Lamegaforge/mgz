@extends('app')
@section('title', 'Megasaurus')
@section('content')
<section class="relative overflow-hidden">
    @if (session()->has('info'))
    <div class="px-4 mx-auto max-w-7xl">
        <div class="relative z-10 px-4 py-2 mx-auto mt-2 text-sm bg-indigo-900 rounded">
            <p>{{session('info')}}</p>
        </div>
    </div>
    @endif
    <img class="absolute top-0 left-0 object-cover w-full h-full blur" src="{{$highlight_clip->thumbnail}}" />
    <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-25"></div>
    <div class="relative px-4 py-16 mx-auto overflow-hidden max-w-7xl sm:px-6 lg:px-8 md:py-20 lg:py-24">
        <div class="flex flex-col md:items-center md:justify-start md:flex-row md:space-x-12">
            <div class="w-full">
                <div class="relative pt-16/9">
                    <iframe allowfullscreen="true" class="absolute top-0 left-0 w-full h-full" width="550" height="275" src="{{'https://clips.twitch.tv/embed?clip='.$highlight_clip->slug.'&parent=megasaurus.fr&parent=staging.megasaurus.fr&autoplay=false'}}">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="px-4 py-16 mx-auto sm:px-6 lg:px-8 md:py-20 lg:py-24 max-w-7xl">
    <h2 class="text-3xl font-light leading-8 tracking-tight text-white sm:text-3xl sm:leading-9">Clips récents</h2>
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
    <h2 class="mt-24 text-3xl font-light leading-8 tracking-tight text-white sm:text-3xl sm:leading-9">Fiches</h2>
    <div class="mt-6">
        @if(count($cards) > 0)
        <carousel :items="{{json_encode($cards)}}" :options="{
            item: {padding: 32},
            responsive: [
              { end: 640, size: 2 },
              { start: 640, end: 768, size: 4 },
              { start: 768, end: 1024, size: 5 },
              { size: 6 }]}">
            @verbatim
            <template #default="{item}">
                <card :item="item" />
            </template>
            @endverbatim
        </carousel>
        @else
        <p class="text-center">Pas encore de fiches 🦕</p>
        @endif
    </div>
</section>
@endsection