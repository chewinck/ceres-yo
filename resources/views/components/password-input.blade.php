@props([
    'id' => 'password',
    'name' => 'password',
    'label' => 'Contraseña',
    'required' => false,
    'placeholder' => 'Escriba aquí',
])

<div x-data="{ show: false }" class="relative">
    <x-input-label :for="$id" :value="__($label . ($required ? ' *' : ''))" />

    <input type="password"
           x-bind:type="show ? 'text' : 'password'"
           {{ $attributes->merge(['class' => 'block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500  text-sm placeholder-gray-500 placeholder-italic text-black  pr-10']) }}
           name="{{ $name }}"
           id="{{ $id }}"
           placeholder="{{ $placeholder }}"
           autocomplete="{{ $name }}"
           {{ $required ? 'required' : '' }} />

    <div @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.953 9.953 0 012.293-3.95M9.88 9.88a3 3 0 104.24 4.24M3 3l18 18"/>
        </svg>
    </div>

    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
