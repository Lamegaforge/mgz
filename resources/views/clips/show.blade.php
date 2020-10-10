@extends('app')
@section('content')
<section class="relative overflow-hidden">
    <img class="absolute top-0 left-0 object-cover w-full h-full blur" src="{{$clip->thumbnail}}" />
    <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50"></div>
    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        @include('layouts.breadcrumbs', [
        'breadcrumbs' => ['Home',
        'Clips',
        'Doom Eternal',
        "C'était quoi ?!"]
        ])
    </div>
    <div class="relative px-4 py-16 mx-auto -mt-6 overflow-hidden max-w-7xl sm:px-6 lg:px-8 md:py-20 lg:py-24">
        <div class="flex flex-col md:items-center md:justify-start md:flex-row md:space-x-12">
            <div class="w-full">
                <div class="relative pt-16/9">
                    <iframe class="absolute top-0 left-0 w-full h-full" width="550" height="275" src="https://www.youtube-nocookie.com/embed/FkklG9MA0vM"></iframe>
                </div>
            </div>
            <div class="flex-grow w-full max-w-sm mt-6 md:w-auto md:mt-0 md:min-w-350px">
                <h1 class="text-4xl font-extrabold leading-10 text-white">{{$clip->title}}</h1>
                <p class="mt-2 text-gray-300">par <a href="" class="font-medium text-white hover:text-indigo-300">{{$clip->user->display_name}}</a></p>
                <div class="flex items-start justify-start mt-3 md:mt-6">
                    <div>
                        <p class="text-sm text-gray-300">Publiée le 23 septembre 2020</p>
                        <p class="text-sm text-gray-300">{comments} commentaires</p>
                        <p class="text-sm text-gray-300">{{$clip->views}} vues</p>
                        <a href="{{route('cards.show', $clip->card->id)}}" class="font-semibold text-white hover:text-indigo-400">{{$clip->card->title}}</a>
                    </div>
                    <a href="{{route('cards.show', $clip->card->id)}}" class="ml-auto">
                        <img class="w-16 rounded" src="{{$clip->card->image_url}}" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="px-4 pb-16 mx-auto mt-12 overflow-hidden sm:px-6 lg:px-8 md:pb-20 lg:pb-24 max-w-7xl">
    <div>
        <h2 class="text-2xl font-light leading-8 tracking-tight text-white sm:text-3xl sm:leading-9">Clips récents</h2>
        <div class="mt-6">

        </div>
    </div>
    <div class="mt-16">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-light leading-8 tracking-tight text-white sm:text-3xl sm:leading-9">Commentaires (2)</h2>
            <span class="rounded shadow-sm">
                <dropdown button-class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-5 text-gray-500 transition duration-150 ease-in-out bg-gray-900 border border-transparent rounded focus:outline-none focus:shadow-outline focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800">
                    <template #trigger>
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                        </svg><span class="ml-2">Trier par</span><svg class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </template>
                    <template #content>
                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="sort-menu">
                            <a href="#" class="block px-4 py-2 text-sm leading-5 text-gray-200 hover:bg-gray-800 focus:outline-none focus:bg-gray-800" role="menuitem">Date</a>
                            <a href="#" class="block px-4 py-2 text-sm leading-5 text-gray-200 hover:bg-gray-800 focus:outline-none focus:bg-gray-800" role="menuitem">Likes</a>
                        </div>
                    </template>
                </dropdown>
            </span>
        </div>
        <div class="mt-6">
            <div>
                <p class="text-sm text-gray-300">Exprime-toi, connard</p>
                <div class="flex max-w-lg mt-1 rounded-sm shadow-sm">
                    <textarea rows="2" class="block w-full transition duration-150 ease-in-out bg-gray-900 border-gray-900 rounded-sm form-textarea sm:text-sm sm:leading-5"></textarea>
                </div>
                <button type="button" class="inline-flex items-center px-3 py-2 mt-1 text-sm font-medium leading-4 text-white transition duration-150 ease-in-out border border-transparent border-gray-700 rounded hover:text-indigo-300 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800" id="options-menu" aria-haspopup="true" aria-expanded="true">
                    Comment
                </button>
            </div>
            <div class="mt-12">

            </div>
        </div>
    </div>
</section>
@endsection