<section>
               @if (session('status'))
                    @php
                        $alertClasses = session('status') === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                        $message = session('message') ?? (session('status') === 'success' ? 'Nueva contraseña guardado con éxito.' : 'Hubo un error al guardar la nueva contraseña.');
                    @endphp

                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        class="flex items-center justify-between p-2 rounded-md text-sm {{ $alertClasses }}"
                    >
                        <span>{{ $message }}</span>
                        <button
                            @click="show = false"
                            class="ml-2 font-bold"
                        >
                            &times;
                        </button>
                    </div>
                @endif
    <header>
        <h2 class="text-lg font-medium text-green-900">
            {{ __('Elegir certificado') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Selecciona el tipo de certificado que desea generar.') }}
        </p>
    </header>



<div x-data="{ tipo: '{{ old('tipoCertificado') }}' }">
<form method="post" action="{{ route('certificado.generar') }}" class="mt-6 space-y-6" x-data="{ tipoCertificado: '{{ old('tipoCertificado') }}' }">
    @csrf

    {{-- Tipo de Certificado --}}
    <div>
        <x-input-label for="tipoCertificado" :value="__('Tipo de certificado *')" />
        <select id="tipoCertificado" name="tipoCertificado"
            class="w-full mt-1 text-black border border-gray-300 rounded-md shadow-sm
                   hover:border-green-500 hover:text-green-700
                   focus:border-green-600 focus:ring focus:ring-green-200 focus:outline-none
                   transition duration-150 ease-in-out px-3 py-3"
            x-model="tipoCertificado">
            <option value="" disabled {{ old('tipoCertificado') ? '' : 'selected' }}>Selecciona</option>
            @foreach ([
                'EVE' => 'Certificado de residencia para fines de Estudio, Vivienda, y Empleo',
                'PPL' => 'Certificado de residencia para personas Privadas de la libertad',
                'PEPA' => 'Certificado de residencia para permiso especial - porte y salvoconducto de armas',
                'TAPEP' => 'Certificado de residencia para trabajo en las áreas de influencia de los proyectos de exploración y explotación petrolera y minera',
            ] as $value => $label)
                <option value="{{ $value }}" {{ old('tipoCertificado') == $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('tipoCertificado')" class="mt-2" />
    </div>

    <input type="hidden" name="categoriaCertificado" value="automatica">

    {{-- Campos adicionales SOLO si tipoCertificado = PPL --}}
    <div x-show="tipoCertificado === 'PPL'" >
    
            <!-- Texto descriptivo -->
            <div class="col-span-1 md:col-span-2 mt-4 mb-6">
                <p class="text-md text-green-600">
                    Ingrese los datos correspondientes a la persona privada de la libertad.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

            <!-- Campo: Nombre del PPL -->
            <div>
                <label for="nombrePPL" class="block font-medium text-sm text-gray-700">Nombre completo *</label>
                <input id="nombrePPL" name="nombrePPL" type="text"
                    class="px-3 py-3 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm block w-full mt-1">
                <x-input-error :messages="$errors->get('nombrePPL')" class="mt-2" />

            </div>

            <!-- Campo: Tipo de Documento -->
            <div>
                <label for="tipoDocumentoPPL" class="block font-medium text-sm text-gray-700">Tipo de Identificación *</label>
                <select id="tipoDocumentoPPL" name="tipoDocumentoPPL"
                        class="w-full mt-1 text-black border border-gray-300 rounded-md shadow-sm
                            hover:border-green-500 hover:text-green-700
                            focus:border-green-600 focus:ring focus:ring-green-200 focus:outline-none
                            transition duration-150 ease-in-out px-3 py-3">
                    <option value="" disabled selected>Selecciona</option>
                    <option value="CC">Cédula de Ciudadanía</option>
                    <option value="CE">Cédula de Extranjería</option>
                    <option value="PA">Pasaporte</option>
                    <option value="DE">Documento Extranjero</option>
                    <option value="RC">Registro civil de nacimiento</option>
                    <option value="TI">Tarjeta de Identidad</option>
                    <option value="PEP">Permiso especial de permanencia</option>
                    <option value="PPT">Permiso por protección Temporal</option>
                </select>
                <x-input-error :messages="$errors->get('tipoDocumentoPPL')" class="mt-2" />
            </div>

            <!-- Campo: Número de Documento -->
            <div>
                <label for="numeroDocumentoPPL" class="block font-medium text-sm text-gray-700 ">Número de Documento *</label>
                <input id="numeroDocumentoPPL" name="numeroDocumentoPPL" type="text"
                    class="px-3 py-3 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm block w-full mt-1">
                <x-input-error :messages="$errors->get('numeroDocumentoPPL')" class="mt-2" />

            </div>

            <!-- Campo: Número de Expediente -->
            <div>
                <label for="numeroExpedientePPL" class="block font-medium text-sm text-gray-700">Número de Expediente *</label>
                <input id="numeroExpedientePPL" name="numeroExpedientePPL" type="text"
                    class="px-3 py-3 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm block w-full mt-1">
                <x-input-error :messages="$errors->get('numeroExpedientePPL')" class="mt-2" />
            </div>

            <!-- Campo: Nombre del Juzgado (ocupa dos columnas) -->
            <div class="md:col-span-2">
                <label for="nombreJuzgado" class="block font-medium text-sm text-gray-700">Nombre del Juzgado *</label>
                <input id="nombreJuzgado" name="nombreJuzgado" type="text"
                    class="px-3 py-3 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm block w-full mt-1">
                <x-input-error :messages="$errors->get('nombreJuzgado')" class="mt-2" />
            </div>
        </div>
    </div>


    {{-- Botón --}}
    <div>
        <x-primary-button>{{ __('Generar Certificado') }}</x-primary-button>
    </div>
</form>

</div>

</section>
