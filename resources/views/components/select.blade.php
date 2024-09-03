@props(['label'])

<div>
    @isset($label)
    <label class="block font-bold dark:text-white">{{ $label }} </label>
    @endisset

    <select {!! $attributes->merge([
        'class' =>
            'border-gray-300 mt-2 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm',
    ]) !!}>
        {{ $slot }}
    </select>
    @error($attributes->get('wire:model'))
        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
