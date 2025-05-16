<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" >
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

         <div >
            <x-input-label for="nacionalidad" :value="__('Nacionalidad *')" />
            <select id="nacionalidad" class="w-full text-sm text-gray-500 italic rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" name="nacionalidad" >
                <option value="">Escoger</option>
                <option value="Colombiana" {{ old('nacionalidad') == 'Colombiana' ? 'selected' : '' }}>Colombiana</option>
                <option value="Extranjera" {{ old('nacionalidad') == 'Extranjera' ? 'selected' : '' }}>Extranjera</option>
            </select>
            <x-input-error :messages="$errors->get('nacionalidad')" class="mt-2" />
        </div>

        <div >
            <x-input-label for="tipoIdentificacion" :value="__('Tipo de Identificación *')" />
            <select id="tipoIdentificacion" class="w-full text-sm text-gray-500 italic rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" name="tipoIdentificacion" >
                <option value=""> Escoger </option>
                <option value="CC" {{ old('tipoIdentificacion') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                <option value="CE" {{ old('tipoIdentificacion') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                <option value="PA" {{ old('tipoIdentificacion') == 'PA' ? 'selected' : '' }}>Pasaporte</option>
                <option value="DE" {{ old('tipoIdentificacion') == 'DE' ? 'selected' : '' }}>Documento Extranjero</option>
                <option value="RC" {{ old('tipoIdentificacion') == 'RC' ? 'selected' : '' }}>Registro civil de nacimiento</option>
                <option value="TI" {{ old('tipoIdentificacion') == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                <option value="PEP" {{ old('tipoIdentificacion') == 'PEP' ? 'selected' : '' }}>Permiso especial de permanencia</option>
                <option value="PPT" {{ old('tipoIdentificacion') == 'PPT' ? 'selected' : '' }}>Permiso por protección Temporal</option>
            </select>
            <x-input-error :messages="$errors->get('tipoIdentificacion')" class="mt-2" />
        </div>

        <div >
            <x-input-label for="numeroIdentificacion" :value="__('Numero de identificación *')" />
            <x-text-input id="numeroIdentificacion" class="block mt-1 w-full italic" type="text" name="numeroIdentificacion" :value="old('numeroIdentificacion')"  autocomplete="número de identificación" placeholder="Escriba aquí"/>
            <x-input-error :messages="$errors->get('numeroIdentificacion')" class="mt-2" />
        </div>

        <div >
            <x-input-label for="fechaExpedicion" :value="__('Fecha de Expedición *')" />
            <input id="fechaExpedicion" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="date" name="fechaExpedicion" :value="old('fechaExpedicion')"  />
            <x-input-error :messages="$errors->get('fechaExpedicion')" class="mt-2" />
        </div>

        <div >
            <x-input-label for="nombre" :value="__('Nombre  completo *')" />
            <x-text-input id="nombre" class="block mt-1 w-full " type="text" name="nombre" :value="old('nombre')"  autofocus autocomplete="nombre" placeholder="Escriba aquí" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <div >
            <x-input-label for="telefono" :value="__('Teléfono ')" />
            <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')"  autocomplete="teléfono" placeholder="Escriba aquí"/>
            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <div>
            <x-input-label :value="__('Tipo de dirección *')" />
            <div class="md:col-span-2">
                <div>
                    <input id="direccionUrbana" type="radio" name="tipoDireccion" value="Urbana" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ old('tipoDireccion') == 'Urbana' ? 'checked' : '' }}>
                    <label for="direccionUrbana" class="ml-2 text-sm text-gray-700">{{ __('Urbana') }}</label>
                </div>
                <div>
                    <input id="direccionRural" type="radio" name="tipoDireccion" value="Rural" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ old('Rural') == 'Rural' ? 'checked' : '' }}>
                    <label for="direccionRural" class="ml-2 text-sm text-gray-700">{{ __('Rural') }}</label>
                </div>
            </div>
            <x-input-error :messages="$errors->get('tipoDireccion')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="barrio" :value="__('Barrio *')" />
            <x-text-input id="barrio" class="block mt-1 w-full" type="text" name="barrio" :value="old('barrio')"  autocomplete="barrio" placeholder="Escriba aquí"/>
            <x-input-error :messages="$errors->get('barrio')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="direccion" :value="__('Dirección *')" />
            <x-text-input id="direccion" class="block mt-1 w-full" type="text" name="direccion" :value="old('direccion')" autocomplete="direccion" placeholder="Escriba aquí"/>
            <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email *')" />
            <x-text-input id="email" class="block mt-1 w-full " type="email" name="email" :value="old('email')"  autocomplete="username" placeholder="Escriba aquí"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-password-input name="password" id="password" label="Contraseña"  />


        <div class="mb-6">
            <x-password-input name="password_confirmation" id="password_confirmation" label="Confirmar Contraseña"  />
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