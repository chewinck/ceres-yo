<x-guest-layout>
    
    <div class="bg-indigo-500 p-1 rounded-xl shadow-lg">
        <div class="flex items-center">
            <!-- Icono de usuario dentro de un círculo decorativo -->
            <div class="bg-white rounded-full p-3 shadow-md">
            <svg class="h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.166 0 4.215.516 6.121 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            </div>
            <h2 class="ml-3 font-extrabold text-white text-base sm:text-xl tracking-tight">Registro Ciudadano</h2>
        </div>
    </div>


    <div class=" bg-brandBlue flex flex-col justify-center  sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-4xl">
            <div class=" bg-brandBlue py-8 px-6 shadow rounded-2xl sm:px-10">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nacionalidad --}}
                        <div>
                            <x-input-label for="nacionalidad" :value="__('Nacionalidad *')" />

                                <select id="nacionalidad" name="nacionalidad"
                                    class="w-full mt-1 text-black border border-gray-300 rounded-md shadow-sm 
                                        hover:border-indigo-500 focus:border-indigo-600 focus:ring-indigo-600 
                                        focus:text-indigo-700 focus:outline-none transition duration-150 ease-in-out">
                                    <option value="" disabled {{ old('nacionalidad') ? '' : 'selected' }}>Selecciona</option>
                                    <option value="Colombiana" {{ old('nacionalidad') == 'Colombiana' ? 'selected' : '' }}>Colombiana</option>
                                    <option value="Extranjera" {{ old('nacionalidad') == 'Extranjera' ? 'selected' : '' }}>Extranjera</option>
                                </select>

                            <x-input-error :messages="$errors->get('nacionalidad')" class="mt-2" />
                        </div>



                        {{-- Tipo de Identificación --}}
                        <div>
                            <x-input-label for="tipoIdentificacion" :value="__('Tipo de Identificación *')" />
                            <select id="tipoIdentificacion" name="tipoIdentificacion" 
                                class="w-full mt-1 text-black border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="" disabled {{ old('tipoIdentificacion') ? '' : 'selected' }}>Selecciona</option>
                                @foreach ([
                                    'CC' => 'Cédula de Ciudadanía',
                                    'CE' => 'Cédula de Extranjería',
                                    'PA' => 'Pasaporte',
                                    'DE' => 'Documento Extranjero',
                                    'RC' => 'Registro civil de nacimiento',
                                    'TI' => 'Tarjeta de Identidad',
                                    'PEP' => 'Permiso especial de permanencia',
                                    'PPT' => 'Permiso por protección Temporal',
                                ] as $value => $label)
                                    <option value="{{ $value }}" {{ old('tipoIdentificacion') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('tipoIdentificacion')" class="mt-2" />
                        </div>

                        {{-- Número de Identificación --}}
                        <div>
                            <x-input-label for="numeroIdentificacion" :value="__('Número de identificación *')" />
                            <x-text-input id="numeroIdentificacion" name="numeroIdentificacion" type="text" 
                                class="block mt-1 w-full text-black"
                                :value="old('numeroIdentificacion')" placeholder="Escriba aquí" />
                            <x-input-error :messages="$errors->get('numeroIdentificacion')" class="mt-2" />
                        </div>

                        {{-- Fecha de Expedición --}}
                        <div>
                            <x-input-label for="fechaExpedicion" :value="__('Fecha de expedición *')" />
                            <x-text-input id="fechaExpedicion" name="fechaExpedicion" type="date" 
                                class="block mt-1 w-full text-black"
                                :value="old('fechaExpedicion')" />
                            <x-input-error :messages="$errors->get('fechaExpedicion')" class="mt-2" />
                        </div>

                        {{-- Nombre --}}
                        <div>
                            <x-input-label for="nombre" :value="__('Nombre completo *')" />
                            <x-text-input id="nombre" name="nombre" type="text" 
                                class="block mt-1 w-full text-black"
                                :value="old('nombre')" placeholder="Escriba aquí" />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>

                        {{-- Teléfono --}}
                        <div>
                            <x-input-label for="telefono" :value="__('Teléfono')" />
                            <x-text-input id="telefono" name="telefono" type="text"
                                class="block mt-1 w-full text-black"
                                :value="old('telefono')" placeholder="Escriba aquí" />
                            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                        </div>

                        {{-- Tipo de Dirección --}}
                        <div>
                            <x-input-label :value="__('Tipo de dirección *')" />
                            <div class="mt-2 flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="tipoDireccion" value="Urbana" 
                                        class="text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                        {{ old('tipoDireccion') == 'Urbana' ? 'checked' : '' }}>
                                    <span class="ml-2 text-black text-sm">Urbana</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="tipoDireccion" value="Rural" 
                                        class="text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                        {{ old('tipoDireccion') == 'Rural' ? 'checked' : '' }}>
                                    <span class="ml-2 text-black text-sm">Rural</span>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('tipoDireccion')" class="mt-2" />
                        </div>

                        {{-- Barrio --}}
                        <div>
                            <x-input-label for="barrio" :value="__('Barrio / Corregimiento *')" />
                            <x-text-input id="barrio" name="barrio" type="text" 
                                class="block mt-1 w-full text-black"
                                :value="old('barrio')" placeholder="Escriba aquí" />
                            <x-input-error :messages="$errors->get('barrio')" class="mt-2" />
                        </div>

                        {{-- Dirección --}}
                        <div>
                            <x-input-label for="direccion" :value="__('Dirección *')" />
                            <x-text-input id="direccion" name="direccion" type="text" 
                                class="block mt-1 w-full text-black"
                                :value="old('direccion')" placeholder="Escriba aquí" />
                            <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <x-input-label for="email" :value="__('Email *')" />
                            <x-text-input id="email" name="email" type="email" 
                                class="block mt-1 w-full text-black"
                                :value="old('email')" placeholder="correo@ejemplo.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Contraseña --}}
                        <div>
                            <x-input-label for="password" :value="__('Contraseña *')" />
                            <x-text-input id="password" name="password" type="password" 
                                class="block mt-1 w-full text-black" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        {{-- Confirmar Contraseña --}}
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña *')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" 
                                class="block mt-1 w-full text-black" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Acciones --}}
                    <div class="md:col-span-2 flex items-center justify-end">
                        <a href="{{ route('login') }}" class="text-sm  mb-2  text-indigo-600 hover:underline">¿Ya tiene una cuenta?</a>
                        <x-primary-button class="ml-4 px-6 py-2 mb-2 ">
                            Registrarme
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    
</x-guest-layout>
