<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create Rule') }}
        </h2>
    </x-slot>

    <div class="pt-6 pb-12 mx-auto max-w-7xl">
        <livewire-rules-form />
    </div>
</x-app-layout>