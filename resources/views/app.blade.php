@php
$links = [
    [
        'Clips',
        '/clips',
        request()->routeIs('clips.index'),
    ],
    [
        'Fiches',
        '/cards',
        request()->routeIs('cards.index'),
    ],
    [
        'Classement',
        '/users',
        request()->routeIs('users.index'),
    ],
    [
        'Aléatoire',
        '/clips/random',
        request()->routeIs('clips.random'),
    ],
];
@endphp
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Megasaurus</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('metas')
</head>

<body class="antialiased">
    <div id="app" class="flex flex-col font-sans text-white bg-black">
        <primary-nav :links="{{json_encode($links)}}" :user="{{json_encode(Auth::user())}}" :notifications="{{$notificationsCount}}"></primary-nav>
        <main class="min-h-screen">
            @yield('content')
        </main>
        @include('parts.footer')
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
</body>

</html>