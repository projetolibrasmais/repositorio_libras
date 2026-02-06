<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    highContrast: localStorage.getItem('highContrast') === 'true',
    fontSize: parseInt(localStorage.getItem('fontSize') || '16'),
    voiceActive: false,
    recognition: null
}" x-init="$watch('highContrast', val => {
    localStorage.setItem('highContrast', val);
    document.documentElement.classList.toggle('high-contrast', val);
});
$watch('fontSize', val => {
    localStorage.setItem('fontSize', val);
    document.documentElement.style.fontSize = val + 'px';
});
if (highContrast) document.documentElement.classList.add('high-contrast');
document.documentElement.style.fontSize = fontSize + 'px';
initVoiceRecognition();">

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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap justify-end items-center gap-4">
            <span class="text-sm">{{ __('Acessibilidade:') }}</span>

            <!-- Font Size Controls -->
            <button @click="fontSize = Math.max(12, fontSize - 2)"
                class="px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded transition-colors text-sm"
                :title="'{{ __('Diminuir fonte') }}'">
                A-
            </button>
            <button @click="fontSize = Math.min(24, fontSize + 2)"
                class="px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded transition-colors text-sm"
                :title="'{{ __('Aumentar fonte') }}'">
                A+
            </button>

            <!-- High Contrast Toggle -->
            <button @click="highContrast = !highContrast" :class="highContrast ? 'bg-blue-600' : 'bg-gray-700'"
                class="px-3 py-1 hover:bg-gray-600 rounded transition-colors flex items-center gap-2 text-sm"
                :title="'{{ __('Alto contraste') }}'">
                <i class="ph ph-circle-half"></i>
                <span>{{ __('Contraste') }}</span>
            </button>

            <!-- Voice Command -->
            <button @click="toggleVoiceCommand()" 
                :class="voiceActive ? 'bg-red-600' : 'bg-gray-700'"
                class="px-3 py-1 hover:bg-gray-600 rounded transition-colors flex items-center gap-2 text-sm"
                :title="voiceActive ? '{{ __('Parar comando de voz') }}' : '{{ __('Iniciar comando de voz') }}'">
                <i class="ph" :class="voiceActive ? 'ph-microphone-slash' : 'ph-microphone'"></i>
                <span x-text="voiceActive ? '{{ __('Parar') }}' : '{{ __('Comando de voz') }}'"></span>
            </button>

            <!-- Language Selector -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" 
                    class="px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded transition-colors flex items-center gap-2 text-sm"
                    :title="'{{ __('Idioma') }}'">
                    <i class="ph ph-globe"></i>
                    <span>
                        @if(app()->getLocale() == 'pt_BR')
                            PT
                        @elseif(app()->getLocale() == 'en')
                            EN
                        @else
                            ES
                        @endif
                    </span>
                    <i class="ph ph-caret-down text-xs"></i>
                </button>
                
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                    <a href="{{ route('locale.switch', 'pt_BR') }}" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() == 'pt_BR' ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                        <i class="ph ph-check mr-2 {{ app()->getLocale() == 'pt_BR' ? '' : 'invisible' }}"></i>
                        {{ __('Português') }}
                    </a>
                    <a href="{{ route('locale.switch', 'en') }}" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() == 'en' ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                        <i class="ph ph-check mr-2 {{ app()->getLocale() == 'en' ? '' : 'invisible' }}"></i>
                        {{ __('Inglês') }}
                    </a>
                    <a href="{{ route('locale.switch', 'es') }}" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() == 'es' ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                        <i class="ph ph-check mr-2 {{ app()->getLocale() == 'es' ? '' : 'invisible' }}"></i>
                        {{ __('Espanhol') }}
                    </a>
                </div>
            </div>
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

        // Voice Recognition System
        function initVoiceRecognition() {
            if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
                console.log('Voice recognition not supported');
                return;
            }

            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            const recognition = new SpeechRecognition();
            
            recognition.continuous = true;
            recognition.interimResults = false;
            
            // Set language based on current locale
            const locale = '{{ app()->getLocale() }}';
            if (locale === 'pt_BR') {
                recognition.lang = 'pt-BR';
            } else if (locale === 'en') {
                recognition.lang = 'en-US';
            } else if (locale === 'es') {
                recognition.lang = 'es-ES';
            }

            recognition.onresult = function(event) {
                const transcript = event.results[event.results.length - 1][0].transcript.toLowerCase().trim();
                console.log('Voice command:', transcript);
                handleVoiceCommand(transcript);
            };

            recognition.onerror = function(event) {
                console.error('Voice recognition error:', event.error);
                if (event.error === 'no-speech') {
                    // Silently ignore no-speech errors
                }
            };

            recognition.onend = function() {
                if (Alpine.store ? Alpine.store('voiceActive') : document.querySelector('[x-data]').__x.$data.voiceActive) {
                    recognition.start(); // Restart if still active
                }
            };

            window.voiceRecognition = recognition;
        }

        function toggleVoiceCommand() {
            const voiceActive = this.voiceActive;
            
            if (!window.voiceRecognition) {
                alert('{{ __('Comando de voz não suportado neste navegador') }}');
                return;
            }

            if (!voiceActive) {
                try {
                    window.voiceRecognition.start();
                    this.voiceActive = true;
                } catch (e) {
                    console.error('Error starting voice recognition:', e);
                }
            } else {
                window.voiceRecognition.stop();
                this.voiceActive = false;
            }
        }

        function handleVoiceCommand(command) {
            const locale = '{{ app()->getLocale() }}';
            
            // Navigation commands
            const commands = {
                pt_BR: {
                    'início': '{{ route('home') }}',
                    'home': '{{ route('home') }}',
                    'sobre': '{{ route('public.about') }}',
                    'sinais': '{{ route('public.sinais') }}',
                    'catálogo': '{{ route('public.catalogo') }}',
                    'categorias': '{{ route('public.categorias') }}',
                    'buscar': () => document.querySelector('input[type="text"]')?.focus(),
                    'aumentar fonte': () => {
                        const el = document.querySelector('[x-data]');
                        if (el && el.__x) el.__x.$data.fontSize = Math.min(24, el.__x.$data.fontSize + 2);
                    },
                    'diminuir fonte': () => {
                        const el = document.querySelector('[x-data]');
                        if (el && el.__x) el.__x.$data.fontSize = Math.max(12, el.__x.$data.fontSize - 2);
                    },
                    'alto contraste': () => {
                        const el = document.querySelector('[x-data]');
                        if (el && el.__x) el.__x.$data.highContrast = !el.__x.$data.highContrast;
                    },
                    'contraste': () => {
                        const el = document.querySelector('[x-data]');
                        if (el && el.__x) el.__x.$data.highContrast = !el.__x.$data.highContrast;
                    }
                },
                en: {
                    'home': '{{ route('home') }}',
                    'about': '{{ route('public.about') }}',
                    'signs': '{{ route('public.sinais') }}',
                    'catalog': '{{ route('public.catalogo') }}',
                    'categories': '{{ route('public.categorias') }}',
                    'search': () => document.querySelector('input[type="text"]')?.focus(),
                    'increase font': () => {
                        const el = document.querySelector('[x-data]');
                        if (el && el.__x) el.__x.$data.fontSize = Math.min(24, el.__x.$data.fontSize + 2);
                    },
                    'decrease font': () => {
                        const el = document.querySelector('[x-data]');
                        if (el && el.__x) el.__x.$data.fontSize = Math.max(12, el.__x.$data.fontSize - 2);
                    },
                    'high contrast': () => {
                        const el = document.querySelector('[x-data]');
                        if (el && el.__x) el.__x.$data.highContrast = !el.__x.$data.highContrast;
                    },
                    'contrast': () => {
                        const el = document.querySelector('[x-data]');
                        if (el && el.__x) el.__x.$data.highContrast = !el.__x.$data.highContrast;
                    }
                },
                es: {
                    'inicio': '{{ route('home') }}',
                    'acerca de': '{{ route('public.about') }}',
                    'señas': '{{ route('public.sinais') }}',
                    'catálogo': '{{ route('public.catalogo') }}',
                    'categorías': '{{ route('public.categorias') }}',
                    'buscar': () => document.querySelector('input[type="text"]')?.focus(),
                    'aumentar fuente': () => {
                        const el = document.querySelector('[x-data]');
                        if (el && el.__x) el.__x.$data.fontSize = Math.min(24, el.__x.$data.fontSize + 2);
                    },
                    'disminuir fuente': () => {
                        const el = document.querySelector('[x-data]');
                        if (el && el.__x) el.__x.$data.fontSize = Math.max(12, el.__x.$data.fontSize - 2);
                    },
                    'alto contraste': () => {
                        const el = document.querySelector('[x-data]');
                        if (el && el.__x) el.__x.$data.highContrast = !el.__x.$data.highContrast;
                    },
                    'contraste': () => {
                        const el = document.querySelector('[x-data]');
                        if (el && el.__x) el.__x.$data.highContrast = !el.__x.$data.highContrast;
                    }
                }
            };

            const localeCommands = commands[locale] || commands.pt_BR;
            
            for (const [key, action] of Object.entries(localeCommands)) {
                if (command.includes(key)) {
                    if (typeof action === 'function') {
                        action();
                    } else {
                        window.location.href = action;
                    }
                    return;
                }
            }
        }
    </script>

    @stack('scripts')
</body>

</html>
