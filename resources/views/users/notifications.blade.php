@extends('app')
@section('title', 'Notifications')
@section('content')
<div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
    @include('layouts.breadcrumbs', [
        'breadcrumbs' => [
            [
                'Accueil', 
                route('home'),
            ],
            'Notifications',
        ],
    ])
</div>
<section class="-mt-6 section">
    <h1 class="text-3xl font-semibold leading-8 tracking-tight text-white md:text-4xl sm:text-3xl sm:leading-9">Notifications</h1>
    <ul class="max-w-2xl mx-auto mt-6 divide-y divide-gray-900">
        @foreach($notifications as $notif)
        <li class="{{ $notif->readed_at ? 'opacity-75' : '' }} space-x-4 flex items-center py-4 px-3 rounded-sm">
            <div class="{{$notif->readed_at ? 'border-transparent': 'border-red-600'}} border-2 p-2 bg-indigo-600 rounded-full">
                @if($notif->content['type'] === 'clip')
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                    </svg>
                @endif
                @if($notif->content['type'] === 'achievement')
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
                @endif
            </div>
            <div class="flex flex-col">
                <p class="text-sm leading-5 text-gray-500">{{$notif->created_at->diffForHumans()}}</p>
                <span class="text-gray-200">{{$notif->content['message'] ?? null}}</span>
            </div>
        </li>
        @endforeach
    </ul>
    @if (!count($notifications))
    <p class="py-16 text-center">Rien à afficher, t'es à jour 🦕</p>
    @endif
</section>
@endsection