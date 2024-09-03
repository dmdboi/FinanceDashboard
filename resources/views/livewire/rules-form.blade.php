<div>
    <form wire:submit.prevent="save" class="space-y-4">

        <!-- Select -->
        <x-select wire:model="property" label="Property" id="property" class="w-full">
            <option value="description" selected>Description</option>
        </x-select>

        <!-- Operator -->
        <x-select wire:model="operator" label="Operator" id="operator" class="w-full">
            <option value="equals">Equals</option>
            <option value="contains">Contains</option>
            <option value="starts_with">Starts With</option>
            <option value="ends_with">Ends With</option>
        </x-select>

        <!-- Value -->
        <x-input type="text" wire:model="value" label="Value" id="url" placeholder="Tesco" class="w-full" />

        <!-- Operator -->
        <x-select wire:model="category_id" label="Category" id="category_id" class="w-full">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </x-select>

        <button type="submit" class="mt-4 btn btn-primary">Submit</button>
    </form>
</div>
