<section>
    <header>
        <h2 class="text-lg font-medium text-blue-900">
            {{ __('Actualizar datos personales') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Actualice la información de su cuenta como requiera. Los nuevos datos serán guardados en nuestra base de datos y serán usados para generar el certificado.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nacionalidad --}}
                        <div>
                            <x-input-label for="nacionalidad" :value="__('Nacionalidad *')" />

                                <select id="nacionalidad" name="nacionalidad"
                                    class="w-full mt-1 text-black border border-gray-300 rounded-md shadow-sm
                                        hover:border-blue-500 hover:text-blue-700
                                        focus:border-blue-600 focus:ring focus:ring-blue-200 focus:outline-none
                                        transition duration-150 ease-in-out ">
                                    <option value="" disabled {{ old('nacionalidad') ? '' : 'selected' }}>Selecciona</option>
                                    <option value="Colombiana" {{ old('nacionalidad', $user->ciudadano->nacionalidad) == 'Colombiana' ? 'selected' : '' }}>Colombiana</option>
                                    <option value="Extranjera" {{ old('nacionalidad', $user->ciudadano->nacionalidad) == 'Extranjera' ? 'selected' : '' }}>Extranjera</option>
                                </select>

                            <x-input-error :messages="$errors->get('nacionalidad')" class="mt-2" />
                        </div>



                        {{-- Tipo de Identificación --}}
                        <div>
                            <x-input-label for="tipoIdentificacion" :value="__('Tipo de Identificación *')" />
                            <select id="tipoIdentificacion" name="tipoIdentificacion" 
                                class="w-full mt-1 text-black border border-gray-300 rounded-md shadow-sm
                                        hover:border-blue-500 hover:text-blue-700
                                        focus:border-blue-600 focus:ring focus:ring-blue-200 focus:outline-none
                                        transition duration-150 ease-in-out ">
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
                                    <option value="{{ $value }}" {{ old('tipoIdentificacion', $user->ciudadano->tipo_identificacion ) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('tipoIdentificacion')" class="mt-2" />
                        </div>

                        {{-- Número de Identificación --}}
                        <div>
                            <x-input-label for="numeroIdentificacion" :value="__('Número de identificación *')" />
                            <x-text-input id="numeroIdentificacion" name="numeroIdentificacion" type="text" 
                                class="block mt-1 w-full text-black "
                                :value="old('numeroIdentificacion', $user->ciudadano->numero_identificacion)" placeholder="Escriba aquí" />
                            <x-input-error :messages="$errors->get('numeroIdentificacion')" class="mt-2" />
                        </div>

                        {{-- Fecha de Expedición --}}
                        <div>
                            <x-input-label for="fechaExpedicion" :value="__('Fecha de expedición *')" />
                            <x-text-input id="fechaExpedicion" name="fechaExpedicion" type="date" 
                                class="block mt-1 w-full text-black "
                                :value="old('fechaExpedicion', $user->ciudadano->fecha_expedicion)" />
                            <x-input-error :messages="$errors->get('fechaExpedicion')" class="mt-2" />
                        </div>

                        {{-- Nombre --}}
                        <div>
                            <x-input-label for="nombre" :value="__('Nombre completo *')" />
                            <x-text-input id="nombre" name="nombre" type="text" 
                                class="block mt-1 w-full text-black "
                                :value="old('nombre', $user->nombre)" placeholder="Escriba aquí" />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>

                        {{-- Teléfono --}}
                        <div>
                            <x-input-label for="telefono" :value="__('Teléfono')" />
                            <x-text-input id="telefono" name="telefono" type="text"
                                class="block mt-1 w-full text-black "
                                :value="old('telefono', $user->ciudadano->telefono)" placeholder="Escriba aquí" />
                            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                        </div>

                        {{-- Tipo de Dirección --}}
                        <div>
                            <x-input-label :value="__('Tipo de dirección *')" />
                            <div class="mt-2 flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="tipoDireccion" value="Urbana" 
                                        class="text-blue-600 border-gray-300 focus:ring-blue-500 "
                                        {{ old('tipoDireccion', $user->ciudadano->tipo_direccion) == 'Urbana' ? 'checked' : '' }}>
                                    <span class="ml-2 text-black text-sm">Urbana</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="tipoDireccion" value="Rural" 
                                        class="text-blue-600 border-gray-300 focus:ring-blue-500 "
                                        {{ old('tipoDireccion', $user->ciudadano->tipo_direccion) == 'Rural' ? 'checked' : '' }}>
                                    <span class="ml-2 text-black text-sm">Rural</span>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('tipoDireccion')" class="mt-2" />
                        </div>

                        {{-- Barrio --}}
                        <div>
                            <x-input-label for="barrio" :value="__('Barrio / Corregimiento *')" />
                            <x-text-input id="barrio" name="barrio" type="text" 
                                class="block mt-1 w-full text-black "
                                :value="old('barrio', $user->ciudadano->barrio)" placeholder="Escriba aquí" />
                            <x-input-error :messages="$errors->get('barrio')" class="mt-2" />
                        </div>

                        {{-- Dirección --}}
                        <div>
                            <x-input-label for="direccion" :value="__('Dirección *')" />
                            <x-text-input id="direccion" name="direccion" type="text" 
                                class="block mt-1 w-full text-black "
                                :value="old('direccion', $user->ciudadano->direccion)" placeholder="Escriba aquí" />
                            <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                        </div>

                        {{-- Email --}}
                        <div>

                       
                    {{-- Acciones --}}
            

        {{-- <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->nombre)"  autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div> --}}

        <div>
            {{-- <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"  autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" /> --}}
            <x-input-label for="email" :value="__('Email *')" />
            <x-text-input id="email" name="email" type="email" 
                class="block mt-1 w-full text-black  "
                :value="old('email',$user->email)" placeholder="correo@ejemplo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('la dirección de correo electrónico no es verficable.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click aquí para re enviar la verificación de correo elecrónico.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __(' Un nuevo link de verificación ha sido enviado a su correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div> 
                <div class="flex items-center gap-4 justify-end mt-6">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Guardado.') }}</p>
            @endif
        </div>
        </div>
    </form>
</section>
