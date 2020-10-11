<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Megasaurus</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="antialiased">
    <div id="app" class="flex flex-col font-sans text-white bg-black">
        <primary-nav></primary-nav>
        <main class="min-h-screen">
            @yield('content')
        </main>
        @include('parts.footer')
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
</body>

</html>