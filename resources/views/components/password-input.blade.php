@props([
    'id' => 'password',
    'name' => 'password',
    'label' => 'Contraseña',
    'required' => false,
    'placeholder' => 'Escriba la contraseña',
])

<div>
    <x-input-label :for="$id" :value="__($label . ($required ? ' *' : ''))" />

    <input
        type="password"
        id="{{ $id }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        autocomplete="new-password"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => ' w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500  placeholder-gray-500 placeholder-italic text-black']) }}
    />

    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
