<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" >
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div >
            <x-input-label for="nacionalidad" :value="__('Nacionalidad')" />
            <x-text-input id="nacionalidad" class="block mt-1 w-full" type="text" name="nacionalidad" :value="old('nacionalidad')" required autocomplete="nacionalidad" />
            <x-input-error :messages="$errors->get('nacionalidad')" class="mt-2" />
        </div>

        <div >
            <x-input-label for="tipoIdentificacion" :value="__('Tipo de Identificación')" />
            <select id="tipoIdentificacion" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="tipoIdentificacion" required>
                <option value="">-- Seleccione tipo de Identificación --</option>
                <option value="CC" {{ old('tipoIdentificacion') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                <option value="CE" {{ old('tipoIdentificacion') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                <option value="DE" {{ old('tipoIdentificacion') == 'DE' ? 'selected' : '' }}>Documento Extranjero</option>
                <option value="PA" {{ old('tipoIdentificacion') == 'PA' ? 'selected' : '' }}>Pasaporte</option>
                <option value="PEP" {{ old('tipoIdentificacion') == 'PEP' ? 'selected' : '' }}>Permiso especial de permanencia</option>
                <option value="PPT" {{ old('tipoIdentificacion') == 'PPT' ? 'selected' : '' }}>Permiso por protección Temporal</option>
            </select>
            <x-input-error :messages="$errors->get('tipoIdentificacion')" class="mt-2" />
        </div>

        <div >
            <x-input-label for="numeroIdentificacion" :value="__('Numero de identificación')" />
            <x-text-input id="numeroIdentificacion" class="block mt-1 w-full" type="text" name="numeroIdentificacion" :value="old('numeroIdentificacion')" required autocomplete="número de identificación" />
            <x-input-error :messages="$errors->get('numeroIdentificacion')" class="mt-2" />
        </div>

        <div >
            <x-input-label for="fechaExpedicion" :value="__('Fecha de Expedición')" />
            <input id="fechaExpedicion" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="date" name="fechaExpedicion" :value="old('fechaExpedicion')" required />
            <x-input-error :messages="$errors->get('fechaExpedicion')" class="mt-2" />
        </div>

        <div >
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="nombre" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <div >
            <x-input-label for="telefono" :value="__('Teléfono')" />
            <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')" required autocomplete="teléfono" />
            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <div>
            <x-input-label :value="__('Tipo de Dirección')" />
            <div class="md:col-span-2">
                <div>
                    <input id="direccion_residencial" type="radio" name="tipoDireccion" value="residencial" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ old('tipoDireccion') == 'residencial' ? 'checked' : '' }}>
                    <label for="direccion_residencial" class="ml-2 text-sm text-gray-700">{{ __('Urbana') }}</label>
                </div>
                <div>
                    <input id="direccion_comercial" type="radio" name="tipoDireccion" value="comercial" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ old('tipoDireccion') == 'comercial' ? 'checked' : '' }}>
                    <label for="direccion_comercial" class="ml-2 text-sm text-gray-700">{{ __('Rural') }}</label>
                </div>
            </div>
            <x-input-error :messages="$errors->get('tipoDireccion')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="direccion" :value="__('Dirección')" />
            <x-text-input id="direccion" class="block mt-1 w-full" type="text" name="direccion" :value="old('direccion')" required autocomplete="direccion" />
            <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="md:col-span-2 flex items-center justify-end">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Ya esta registrado?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </div>

    </form>
</x-guest-layout>