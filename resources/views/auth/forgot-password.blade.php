<x-guest-layout>
    <div class="mb-4">
        <h2 class="text-2xl font-bold text-gray-900">
            {{ __('Esqueceu sua senha?') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __('Sem problemas. Apenas nos informe seu endereço de e-mail e enviaremos um link para redefinir sua senha.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('E-mail')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Enviar Link de Redefinição') }}
            </x-primary-button>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-800 underline">
                {{ __('Voltar para o Login') }}
            </a>
        </div>
    </form>
</x-guest-layout>
