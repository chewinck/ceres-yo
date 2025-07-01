<x-guest-layout-large>
    <!-- source:https://codepen.io/owaiswiz/pen/jOPvEPB -->
    {{-- <div class="min-h-screen text-gray-900 flex justify-center"> --}}
    <div class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1">
        <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            
            <x-auth-session-status class="mb-1" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mt-2 flex flex-col items-center">

                    <div class=" w-full flex-1 mt-1">
                        <div class="flex flex-col items-center mb-6">
                            <h1
                                class="w-full max-w-xs text-3xl font-bold shadow-sm rounded-lg py-3 text-black-800 flex items-center justify-center transition-all duration-300 ease-in-out">
                                Inicio de Sesión
                            </h1>
                            <div>
                                <img src="{{ asset('storage/linea-bandera-amy.png') }}" alt="Colores bandera Yopal" class="w-full h-auto">
                            </div>
                        </div>
                        
                        <!-- Session Status -->


                        <div class="mx-auto max-w-xs ">
                            <div class="mb-6">
                                <x-input-label for="email" :value="__('Correo electrónico o número de documento *')" />
                                <x-text-input id="email" class="w-full px-8 py-4 font-medium bg-brandBlue  "
                                    type="text" name="email" :value="old('email')" autofocus autocomplete="username"
                                    placeholder="Ejemplo: usuario@correo.com" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <x-password-input class="w-full px-8 py-4 font-medium bg-brandBlue" id="password"
                                name="password" label="Contraseña *" />
                        </div>

                        {{-- <button
                            class="mt-8 tracking-wide font-semibold bg-green-400 text-white-500 w-full py-4 rounded-lg hover:bg-green-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                            <span class="ml-">
                                Ingresar
                            </span>
                        </button> --}}



                        {{-- <p class="mt-6 text-xs text-gray-600 text-center">
                            I agree to abide by Cartesian Kinetics
                            <a href="#" class="border-b border-gray-500 border-dotted">
                                Terms of Service
                            </a>
                            and its
                            <a href="#" class="border-b border-gray-500 border-dotted">
                                Privacy Policy
                            </a>
                        </p> --}}
                        <div class="mb-3 mt-6">
                            <div class="g-recaptcha scale-90 " data-sitekey="{{ config('services.recaptcha.site') }}">
                            </div>
                            <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
                        </div>

                        {{-- Links de recuperación y registro --}}


                        <div class="flex justify-between gap-4 mt-6">
                            {{-- Columna izquierda: links verticales --}}
                            <div class="flex flex-col items-start gap-1">
                                @if (Route::has('password.request'))
                                    <a class="underline text-sm text-green-600 hover:text-green-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                        href="{{ route('password.request') }}">
                                        {{ __('Olvidó su contraseña?') }}
                                    </a>
                                @endif

                                @if (Route::has('register'))
                                    <a class="underline text-sm text-green-600 hover:text-green-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                        href="{{ route('register') }}">
                                        {{ __('Quiero registrarme') }}
                                    </a>
                                @endif
                            </div>

                            {{-- Botón a la derecha --}}
                            <x-primary-button class="px-6 py-2">
                                {{ __('Ingresar') }}
                            </x-primary-button>
                        </div>


                    </div>

                </div>
            </form>
        </div>
        <div class="flex-1 bg-gray-100 text-center hidden lg:flex">
            <div class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
                style="background-image: url('{{ asset('storage/escudo-yopal-grande.webp') }}');">
            </div>

        </div>
    </div>
    {{-- </div> --}}

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</x-guest-layout-large>
