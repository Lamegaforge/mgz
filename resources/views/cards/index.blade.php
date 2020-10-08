@extends('app')
@section('content')
<section class="section">
    <h1 class="text-3xl font-semibold leading-8 tracking-tight text-white md:text-4xl sm:text-3xl sm:leading-9">Toutes les fiches</h1>
    <div class="flex flex-col items-start mt-4 space-y-3 md:mt-6 sm:space-y-0 sm:space-x-3 sm:items-center sm:flex-row">
        <input class="w-full bg-gray-800 border-transparent rounded-full sm:w-64 sm:ml-auto form-input" id="search" placeholder="Rechercher" type="search" />
    </div>

    <div class="grid grid-cols-2 mt-6 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-x-6 gap-y-10">
        @foreach ($cards['data'] as $card)
        @component('components.card')

        @slot('title')
        {{$card['title']}}
        @endslot

        @slot('url')
        url
        @endslot

        @slot('cover')
        Pouet
        @endslot

        @endcomponent
        @endforeach
    </div>
</section>

@endsection