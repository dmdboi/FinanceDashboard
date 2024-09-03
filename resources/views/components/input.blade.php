@props(['disabled' => false, 'label'])

<div>
    @isset($label)
        <label class="block font-bold dark:text-white">{{ $label }} </label>
    @endisset

    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' => 'border-gray-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm',
    ]) !!}>
</div>
