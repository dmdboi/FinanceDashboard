<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

use App\Models\File;

use App\Jobs\ProcessTrx;

use Illuminate\Support\Facades\Storage;

class TrxUpload extends Component
{

    use WithFileUploads;

    #[Validate(['file' => 'mimes:txt'])]
    public $file;

    public function save()
    {
        // Rename and store the file
        $month = now()->format('Y-m');

        // Get the uploaded file content
        $filePath = $this->file->getRealPath();
        $content = file_get_contents($filePath);

        // Convert the encoding from ISO-8859-1 to UTF-8
        $utf8Content = mb_convert_encoding($content, 'UTF-8', 'ISO-8859-1');

        // Create a new filename (you can modify this as needed)
        $filename = 'uploads/' . $month . '.txt';

        // Save the UTF-8 encoded file to the public directory
        Storage::disk('public')->put(
            $filename,
            $utf8Content
        );

        // Save the file to the database
        File::create([
            'name' => $month,
            'path' => 'uploads/' . $month,
            'type' => 'txt',
            'size' => $this->file->getSize(),
            'user_id' => auth()->id(),
        ]);

        // Clear the input
        $this->file = null;

        // Dispatch processTrx job
        ProcessTrx::dispatchSync($filename);

        // Show a success message
        session()->flash('message', 'File uploaded successfully!');
    }

    public function render()
    {
        return view('livewire.trx-upload');
    }
}
