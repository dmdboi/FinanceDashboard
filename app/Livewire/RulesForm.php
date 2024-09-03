<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

use App\Models\Rule;

class RulesForm extends Component
{

    public $property = 'description';

    public $operator;

    public $value;

    public $category_id;

    public $categories;

    public function save() {
        $this->validate([
            'property' => 'required',
            'operator' => 'required',
            'value' => 'required',
            'category_id' => 'required',
        ]);

        Rule::create([
            'property' => $this->property,
            'operator' => $this->operator,
            'value' => $this->value,
            'category_id' => $this->category_id,
            'user_id' => auth()->id(),
        ]);

        $this->reset();
        redirect()->route('rules.index');
    }

    public function mount() {
        $this->categories = Category::query()->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.rules-form', [
            'categories' => $this->categories,
        ]);
    }
}
