<!DOCTYPE html>
<html lang="ru" class="h-full bg-zinc-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог сценариев</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    @endif

    @fluxAppearance
    @livewireStyles
</head>
<body class="min-h-full bg-[radial-gradient(circle_at_top_left,_rgba(56,189,248,0.14),_transparent_24%),radial-gradient(circle_at_top_right,_rgba(16,185,129,0.12),_transparent_28%),linear-gradient(180deg,_#f8fafc_0%,_#eef2ff_100%)] text-zinc-950 antialiased">
    @yield('content')

    @fluxScripts
    @livewireScripts
</body>
</html>
