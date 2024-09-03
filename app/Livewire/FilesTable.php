<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\File;

class FilesTable extends Component
{

    use WithPagination;

    protected $files = [];

    public function render()
    {
        return view('livewire.files-table', [
            'files' => File::query()->orderBy('created_at', 'desc')->paginate(15),
        ]);
    }
}
