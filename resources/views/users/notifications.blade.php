@extends('app')
@section('content')
<div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
    @include('layouts.breadcrumbs', [
    'breadcrumbs' => [
    ['Accueil', route('home')],
    'Notifications'
    ]
    ])
</div>
<section class="-mt-6 section">
    <h1 class="text-3xl font-semibold leading-8 tracking-tight text-white md:text-4xl sm:text-3xl sm:leading-9">Notifications</h1>
    <ul class="max-w-2xl mx-auto mt-6 divide-y divide-gray-900">
        @foreach($notifications as $notif)
        <li class="flex flex-col py-4">
            <p class="text-sm leading-5 text-gray-500">{{$notif->created_at->diffForHumans()}}</p>
            <span class="text-gray-200">{{$notif->message}}</span>
        </li>
        @endforeach
    </ul>
    @if (!count($notifications))
    <p class="py-16 text-center">Rien à afficher, t'es à jour.</p>
    @endif
</section>
@endsection