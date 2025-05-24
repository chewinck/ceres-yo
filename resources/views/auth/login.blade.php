<x-guest-layout-large>
<!-- source:https://codepen.io/owaiswiz/pen/jOPvEPB -->
{{-- <div class="min-h-screen text-gray-900 flex justify-center"> --}}
    <div class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1">
        <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            <div>
                <img src="{{ asset('storage/escudo-yopal.jpg') }}" alt="Escudo de Yopal" class="w-32 h-auto mx-auto">
            </div>

            <div class="mt-5 flex flex-col items-center">
                <div class=" w-full flex-1 mt-2">
                    <div class="flex flex-col items-center mb-6">
                        <h1
                            class="w-full max-w-xs font-bold shadow-sm rounded-lg py-3  text-gray-800 flex items-center justify-center transition-all duration-300 ease-in-out">
                            <svg class="w-6 h-6 -ml-2" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                <circle cx="8.5" cy="7" r="4" />
                                <path d="M20 8v6M23 11h-6" />
                            </svg>
                            <span class="ml-4">Inicio de Sesión</span>
                        </h1>


                    </div>

                    {{-- <div class="my-12 border-b text-center">
                        <div
                            class="leading-none px-2 inline-block text-sm text-gray-600 tracking-wide font-medium bg-white transform translate-y-1/2">
                            Or sign In with Cartesian E-mail
                        </div>
                    </div> --}}
                    <div class="mx-auto max-w-xs ">
                        {{-- <input
                            class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
                            type="email" placeholder="Email" /> --}}
                        {{-- <input class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                            type="password" placeholder="Password" /> --}}
                            <!-- Email Address -->
                        <div class="mb-6">
                            <x-input-label for="email" :value="__('Correo electrónico *')" />
                            <x-text-input id="email" class="w-full px-8 py-4 font-medium bg-brandBlue " type="email" name="email" :value="old('email')"  autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <x-password-input class="w-full px-8 py-4 font-medium mt 4 bg-brandBlue" id="password" name="password" label="Contraseña *" />

                            
                        <button
                            class="mt-8 tracking-wide font-semibold bg-indigo-400 text-white-500 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                            <span class="ml-">
                                Ingresar
                            </span>
                        </button>
                        <p class="mt-6 text-xs text-gray-600 text-center">
                            I agree to abide by Cartesian Kinetics
                            <a href="#" class="border-b border-gray-500 border-dotted">
                                Terms of Service
                            </a>
                            and its
                            <a href="#" class="border-b border-gray-500 border-dotted">
                                Privacy Policy
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 bg-indigo-100 text-center hidden lg:flex">
            <div class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
             style="background-image: url('{{ asset('storage/imagenInicioSesión.svg') }}');">
            </div>

        </div>
    </div>
{{-- </div> --}}

    
</x-guest-layout-large>
