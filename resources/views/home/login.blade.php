@extends('app')
@section('content')
<div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
    @include('layouts.breadcrumbs', [
    'breadcrumbs' => [
    ['Home', route('home')],
    'Connexion']
    ])
</div>
<section class="flex items-center justify-center min-h-full text-center section">
    <div class="p-3">
        <h1 class="text-3xl font-semibold leading-8 tracking-tight text-white md:text-4xl sm:text-3xl sm:leading-9">Connexion</h1>
        <p class="mt-2 text-gray-400">Ici tu peux te connecter avec ton compte Twitch.</p>
        <a href='{{$authorization_url}}' class="inline-flex items-center justify-between px-6 py-3 mt-6 text-lg font-medium leading-6 text-white bg-indigo-700 hover:bg-indigo-600">
            <span>Se connecter avec</span>
            <span class="ml-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-5 h-5" title="Twitch">
                    <path fill="currentColor" d="M391.17,103.47H352.54v109.7h38.63ZM285,103H246.37V212.75H285ZM120.83,0,24.31,91.42V420.58H140.14V512l96.53-91.42h77.25L487.69,256V0ZM449.07,237.75l-77.22,73.12H294.61l-67.6,64v-64H140.14V36.58H449.07Z"></path>
                </svg>
            </span>
        </a>
    </div>
</section>
@endsection