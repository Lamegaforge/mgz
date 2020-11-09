@inject('mediaService', 'App\Services\MediaService')
@inject('iframeService', 'App\Services\IframeService')

@extends('app')
@section('title', $clip->title)
@push('metas')
<x-meta :clip="$clip"/>
@endpush
@section('content')
<section class="relative overflow-hidden">
    <img class="absolute top-0 left-0 object-cover w-full h-full blur" src="{{$clip->thumbnail}}" />
    <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50"></div>
    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        @include('layouts.breadcrumbs', [
            'breadcrumbs' => [
                [
                    'Accueil', 
                    route('home'),
                ],
                [
                    'Fiches', 
                    route('cards.index'),
                ],
                [
                    $clip->card->title, 
                    route('cards.show', $clip->card->slug)
                ],
                $clip->title,
            ],
        ])
    </div>
    <div class="relative px-4 py-16 mx-auto -mt-6 overflow-hidden max-w-7xl sm:px-6 lg:px-8 md:py-20 lg:py-24">
        <div class="flex flex-col md:items-center md:justify-start md:flex-row md:space-x-12">
            <div class="w-full">
                <div class="relative pt-16/9">
                    <iframe allowfullscreen="true" class="absolute top-0 left-0 w-full h-full" width="550" height="275" src="{{$iframeService->url($clip)}}"></iframe>
                </div>
            </div>
            <div class="flex-grow w-full max-w-sm mt-6 md:w-auto md:mt-0 md:min-w-350px">
                <h1 class="text-4xl font-extrabold leading-10 text-white">{{$clip->title}}</h1>
                <p class="mt-2 text-gray-300">par <a href="{{route('users.show', $clip->user->login ?: $clip->user->id)}}"class="font-medium text-white hover:text-indigo-400">{{$clip->user->display_name}}</a></p>
                <div>
                    <favorite-button :clip-id="{{$clip->id}}" :active="@json($isFavorite)" :is-auth="@json(Auth::check())"></favorite-button>
                </div>
                @can('reject', $clip)
                <div>
                    <reject-button :clip-id="{{$clip->id}}"></reject-button>
                </div>
                @endcan
                <div class="flex items-start justify-start mt-3 md:mt-4">
                    <div>
                        <p class="text-sm text-gray-300">Publié le @datetime($clip->approved_at)</p>
                        <p class="text-sm text-gray-300">{{$comment_count}} commentaires</p>
                        <p class="text-sm text-gray-300">{{$clip->views}} vues</p>
                        <a href="{{route('cards.show', $clip->card->slug)}}" class="font-semibold text-white hover:text-indigo-400">{{$clip->card->title}}</a>
                    </div>
                    <a href="{{route('cards.show', $clip->card->slug)}}" class="w-16 ml-auto">
                        <div class="relative shadow-md pt-2/3">
                            <img class="absolute top-0 left-0 object-cover object-center w-full h-full rounded" src="{{$mediaService->vignette($clip->card->slug)}}" />
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="px-4 pb-16 mx-auto mt-12 overflow-hidden sm:px-6 lg:px-8 md:pb-20 lg:pb-24 max-w-7xl">
    <div>
        <h2 class="text-2xl font-light leading-8 tracking-tight text-white sm:text-3xl sm:leading-9">Autres clips</h2>
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
    </div>
    <div class="mt-16">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-light leading-8 tracking-tight text-white sm:text-3xl sm:leading-9">Commentaires ({{$comment_count}})</h2>
        </div>
        <div class="mt-6">
            @auth
            <post-comment :clip-id="{{$clip->id}}"></post-comment>
            @endauth
            <div class="mt-12">
                <comments :is-auth="@json(Auth::check())" fetch-url="{{route('api.comments.search', ['clip_id' => $clip->id])}}" />
            </div>
        </div>
    </div>
</section>
@endsection
