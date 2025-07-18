@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->class([
        'border-gray-300',
        'focus:border-green-500',
        'focus:ring-green-500',
        'rounded-md',
        'shadow-sm'
    ]) }}
>
