<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Transaction;

class TransactionsTable extends Component
{

    use WithPagination;

    protected $transactions = [];

    public $search = '';

    public function mount()
    {
        $this->transactions = $this->listTransactions();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function listTransactions()
    {
        return Transaction::query()
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function render()
    {
        return view('livewire.transactions-table', [
            'transactions' => Transaction::query()
                ->orderBy('created_at', 'desc')
                ->when($this->search, function($query) {
                    return $query->where('description', 'like', '%'.$this->search.'%');
                })
                ->paginate(15)
        ]);
    }
}
