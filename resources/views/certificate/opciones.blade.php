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

    <form method="post" action="{{ route('certificado.generar') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')

        {{-- Tipo de Certificado --}}
                        <div>
                            <x-input-label for="tipoCertificado" :value="__('Tipo de certificado *')" />
                            <select id="tipoCertificado" name="tipoCertiticado"
                                class="w-full mt-1 text-black border border-gray-300 rounded-md shadow-sm
                                        hover:border-green-500 hover:text-green-700
                                        focus:border-green-600 focus:ring focus:ring-green-200 focus:outline-none
                                        transition duration-150 ease-in-out px-3 py-3">
                                <option value="" disabled {{ old('tipoCertificado') ? '' : 'selected' }}>
                                    Selecciona</option>
                                @foreach ([
                                    'EVE' => 'Certificado de residencia para fines de Estudio, Vivienda, y Empleo',
                                    'PPL' => 'Certificado de residencia para personas Privadas de la libertad',
                                    'PEPA' => 'Certificado de residencia para permiso especial - porte y salvoconducto de armas',
                                    'TAPEP' => 'Certificado de residencia para trabajo en las áreas de influencia de los proyectos de exploración y explotación petrolera y minera',
                                ] as $value => $label)
                                    {{-- Genera las opciones del select dinámicamente --}}
                                    <option value="{{ $value }}"
                                        {{ old('tipoCertificado') == $value ? 'selected' : '' }}>{{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('tipoCertificado')" class="mt-2" />
                        </div>

                        <input type="hidden" name="categoriaCertificado" value="automatico">

        <!-- <div>
            <x-input-label for="update_password_password" :value="__('Nueva contraseña *')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full " autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar nueva contraseña *')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full " autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div> -->

        <div class="flex items-center gap-4 justify-end">
            <x-primary-button>{{ __('Generar') }}</x-primary-button>
        </div>
    </form>
</section>
