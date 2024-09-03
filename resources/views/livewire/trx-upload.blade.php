<div>
    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <input type="file" wire:model="file" class="@error('file') border-red-500 @enderror">

        @error('file')
            <span class="error">{{ $message }}</span>
        @enderror

        <button type="submit">Upload</button>
    </form>
</div>
