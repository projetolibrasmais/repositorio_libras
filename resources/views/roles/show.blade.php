<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes da Função') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Visualizar Função"
                    description="Detalhes completos da função {{ $role->name }}">
                    <x-slot name="action">
                        <div class="flex gap-2">
                            <a href="{{ route('roles.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-colors">
                                <i class="ph ph-arrow-left mr-2"></i>
                                Voltar
                            </a>
                            @can('edit_roles')
                                <a href="{{ route('roles.edit', $role) }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <i class="ph ph-pencil mr-2"></i>
                                    Editar
                                </a>
                            @endcan
                        </div>
                    </x-slot>
                </x-page-header>

                <!-- Role Details -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Info Card -->
                    <div class="lg:col-span-2">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="ph ph-info mr-2 text-blue-600"></i>
                                    Informações Gerais
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <!-- Role Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Nome da Função
                                    </label>
                                    <p class="text-sm text-gray-900 bg-gray-50 rounded-lg p-3">
                                        {{ $role->name }}
                                    </p>
                                </div>

                                <!-- Guard Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Guard
                                    </label>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="ph ph-shield-check mr-1"></i>
                                        {{ $role->guard_name }}
                                    </span>
                                </div>

                                <!-- ID -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        ID
                                    </label>
                                    <p class="text-sm text-gray-900 font-mono bg-gray-50 rounded-lg p-3">
                                        #{{ $role->id }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Info -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Timestamps Card -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="ph ph-clock mr-2 text-blue-600"></i>
                                    Registro
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <!-- Created At -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">
                                        Criado em
                                    </label>
                                    <p class="text-sm text-gray-900 flex items-center">
                                        <i class="ph ph-calendar-plus mr-2 text-gray-400"></i>
                                        {{ $role->created_at->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 ml-6">
                                        {{ $role->created_at->format('H:i:s') }}
                                    </p>
                                </div>

                                <!-- Updated At -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">
                                        Atualizado em
                                    </label>
                                    <p class="text-sm text-gray-900 flex items-center">
                                        <i class="ph ph-calendar-check mr-2 text-gray-400"></i>
                                        {{ $role->updated_at->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 ml-6">
                                        {{ $role->updated_at->format('H:i:s') }}
                                    </p>
                                </div>

                                <!-- Difference -->
                                <div class="pt-3 border-t border-gray-100">
                                    <p class="text-xs text-gray-500">
                                        <i class="ph ph-timer mr-1"></i>
                                        Criado {{ $role->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Card -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="ph ph-chart-bar mr-2 text-blue-600"></i>
                                    Estatísticas
                                </h3>
                            </div>
                            <div class="p-6">
                                <!-- Permissions Count -->
                                <div class="flex items-center justify-between py-3">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="ph ph-lock-key text-blue-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Permissões</p>
                                            <p class="text-xs text-gray-500">Associadas a esta função</p>
                                        </div>
                                    </div>
                                    <span class="text-2xl font-bold text-gray-900">
                                        {{ $role->permissions()->count() }}
                                    </span>
                                </div>

                                <!-- Users Count -->
                                <div class="flex items-center justify-between py-3 border-t border-gray-100">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <i class="ph ph-users text-purple-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Usuários</p>
                                            <p class="text-xs text-gray-500">Com esta função</p>
                                        </div>
                                    </div>
                                    <span class="text-2xl font-bold text-gray-900">
                                        {{ $role->users()->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permissions with this Role -->
                @if ($role->permissions()->count() > 0)
                    <div class="mt-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="ph ph-lock-key mr-2 text-blue-600"></i>
                                Permissões desta Função
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-wrap gap-2">
                                @foreach ($role->permissions as $permission)
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        <i class="ph ph-lock-key mr-1"></i>
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
