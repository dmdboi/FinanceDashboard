<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Files') }}
        </h2>
    </x-slot>

    <x-slot name="actions">
        <a href="{{ route('transactions.index') }}"
            class="inline-flex items-center px-4 py-2 text-sm font-semibold leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
            Upload File
        </a>
    </x-slot>
s
    <div class="pt-6 pb-12 mx-auto max-w-7xl">
        <livewire-files-table />
    </div>
</x-app-layout>
