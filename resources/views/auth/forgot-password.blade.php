<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-4 sm:pt-0">
        <div class="max-w-md mx-auto bg-white sm:rounded-lg px-6 py-4">
            <div>
                <img src="{{ asset('storage/escudo-yopal.jpg') }}" alt="Escudo de Yopal" class="w-32 h-auto mx-auto">
            </div>
            <div class="flex flex-col items-center mb-6">
                <h1
                    class="w-full max-w-xs text-3xl font-bold shadow-sm rounded-lg py-3 text-green-800 flex items-center justify-center transition-all duration-300 ease-in-out">
                    Recuperar contraseña
                </h1>
            </div>
            <div class="mb-4 text-sm text-gray-600">
                {{ __('¿Olvidó su contraseña?, ingrese su correo y le enviaremos un enlace para tener una nueva.') }}
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-6">
                    <x-input-label for="email" :value="__('Correo electrónico *')" />
                    <x-text-input id="email" class="w-full px-8 py-4 font-medium bg-brandBlue text-sm "
                        type="email" name="email" :value="old('email')" autofocus autocomplete="username"
                        placeholder="Ejemplo: usuario@correo.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('restablecer contraseña') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
