<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Rule;

class RulesTable extends Component
{

    protected $rules = [];
    

    public function render()
    {
        return view('livewire.rules-table', [
            'rules' => Rule::query()
                ->orderBy('created_at', 'desc')
                ->paginate(15)
        ]);
    }
}
