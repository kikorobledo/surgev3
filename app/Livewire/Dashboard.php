<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class Dashboard extends Component
{

    use WithPagination;

    public $paginator = 10;
    public $search;
    public $sortField = 'id';
    public $sortDirection = 'asc';

    protected $queryString = ['sortField', 'sortDirection'];

    public function sortBy($field){

        if($this->sortField === $field){

            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';

        }else{

            $this->sortDirection = 'asc';

        }

        $this->sortField = $field;

    }

    #[Layout('components.layouts.base')]
    #[Title('Dashboard')]
    public function render()
    {

        $transactions = Transaction::where('title', 'like', '%' . $this->search . '%')
                                        ->orderBy($this->sortField, $this->sortDirection)
                                        ->paginate(10);

        return view('livewire.dashboard', compact('transactions'));
    }
}
