<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    highContrast: localStorage.getItem('highContrast') === 'true',
    fontSize: parseInt(localStorage.getItem('fontSize') || '16')
}" x-init="$watch('highContrast', val => {
    localStorage.setItem('highContrast', val);
    document.documentElement.classList.toggle('high-contrast', val);
});
$watch('fontSize', val => {
    localStorage.setItem('fontSize', val);
    document.documentElement.style.fontSize = val + 'px';
});
if (highContrast) document.documentElement.classList.add('high-contrast');
document.documentElement.style.fontSize = fontSize + 'px';">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Phosphor Icons -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.2/src/regular/style.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* High Contrast Mode */
        .high-contrast {
            filter: contrast(1.5) saturate(0);
        }

        .high-contrast img,
        .high-contrast video {
            filter: contrast(1.2);
        }

        /* VLibras */
        [vw] .enabled {
            background-color: rgb(37 99 235) !important;
        }
    </style>

    <!-- VLibras -->
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
</head>

<body class="font-sans antialiased bg-[#F2F2F2]">
    <!-- Accessibility Bar -->
    <div class="bg-gray-800 text-white py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-end items-center gap-4">
            <span class="text-sm">Acessibilidade:</span>

            <!-- Font Size Controls -->
            <button @click="fontSize = Math.max(12, fontSize - 2)"
                class="px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded transition-colors text-sm"
                title="Diminuir fonte">
                A-
            </button>
            <button @click="fontSize = Math.min(24, fontSize + 2)"
                class="px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded transition-colors text-sm"
                title="Aumentar fonte">
                A+
            </button>

            <!-- High Contrast Toggle -->
            <button @click="highContrast = !highContrast" :class="highContrast ? 'bg-blue-600' : 'bg-gray-700'"
                class="px-3 py-1 hover:bg-gray-600 rounded transition-colors flex items-center gap-2 text-sm"
                title="Alto contraste">
                <i class="ph ph-circle-half"></i>
                <span>Contraste</span>
            </button>
        </div>
    </div>

    <!-- Navigation -->
    <x-public-navbar />

    <!-- Page Content -->
    <main class="flex-grow min-h-[90vh]">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-public-footer />

    <!-- VLibras Widget -->
    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>

    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>

    @stack('scripts')
</body>

</html>
