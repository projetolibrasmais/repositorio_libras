<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Phosphor Icons -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.2/src/regular/style.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ sidebarCollapsed: false }" @sidebar-toggled.window="sidebarCollapsed = $event.detail.collapsed" class="min-h-screen bg-gray-100 flex flex-col">
            <!-- Container com Sidebar e Conteúdo -->
            <div class="flex flex-1 overflow-hidden">
                <!-- Sidebar -->
                <x-sidebar />
                
                <!-- Main Content Area -->
                <div class="flex-1 overflow-y-auto transition-all duration-300"
                    :class="sidebarCollapsed ? 'lg:ml-20' : 'lg:ml-[280px]'">
                    <!-- Navigation no topo -->
                    @include('layouts.navigation')

                    <!-- Page Content -->
                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>

        <!-- Toast Notifications -->
        <x-toast />

        <!-- Flash Messages -->
        @if(session('success'))
            <script>
                document.addEventListener('alpine:init', () => {
                    setTimeout(() => {
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: {
                                type: 'success',
                                message: '{{ session('success') }}'
                            }
                        }));
                    }, 100);
                });
            </script>
        @endif

        @if(session('error'))
            <script>
                document.addEventListener('alpine:init', () => {
                    setTimeout(() => {
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: {
                                type: 'error',
                                message: '{{ session('error') }}'
                            }
                        }));
                    }, 100);
                });
            </script>
        @endif

        @if(session('warning'))
            <script>
                document.addEventListener('alpine:init', () => {
                    setTimeout(() => {
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: {
                                type: 'warning',
                                message: '{{ session('warning') }}'
                            }
                        }));
                    }, 100);
                });
            </script>
        @endif

        @if(session('info'))
            <script>
                document.addEventListener('alpine:init', () => {
                    setTimeout(() => {
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: {
                                type: 'info',
                                message: '{{ session('info') }}'
                            }
                        }));
                    }, 100);
                });
            </script>
        @endif

        @if($errors->any())
            <script>
                document.addEventListener('alpine:init', () => {
                    setTimeout(() => {
                        @foreach($errors->all() as $error)
                            window.dispatchEvent(new CustomEvent('toast', {
                                detail: {
                                    type: 'error',
                                    message: '{{ $error }}',
                                    duration: 6000
                                }
                            }));
                        @endforeach
                    }, 100);
                });
            </script>
        @endif

        @stack('scripts')
    </body>
</html>
