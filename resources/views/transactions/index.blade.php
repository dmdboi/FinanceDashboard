<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="pt-6 pb-12 mx-auto max-w-7xl">
        <livewire-transactions-table />
    </div>
</x-app-layout>
