<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class Dashboard extends Component
{

    use WithPagination;

    public $paginator = 10;
    public $sortField = 'id';
    public $sortDirection = 'asc';

    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showFilters = false;

    public $selected = [];
    public $selectPage = false;
    public $selectAll = false;

    public Transaction $editing;
    public $date;

    public $filters = [
        'search' => '',
        'status' => '',
        'amount-min' => null,
        'amount-max' => null,
        'date-min' => null,
        'date-max' => null,
    ];

    protected $queryString = ['sortField', 'sortDirection'];

    protected function rules(){
        return [
            'editing.title' => 'required',
            'editing.amount' => 'required',
            'editing.status' => 'required|in:' . collect(Transaction::STATUSES)->keys()->implode(','),
            'date' => 'required',
         ];
    }

    public function updatedFilters(){
        $this->resetPage();
    }

    public function updatedDate(){

        $this->editing->date = Carbon::createFromFormat('d/m/Y', $this->date);

    }

    public function updatedSelectPage($value){

        if($value){

            $this->selected = $this->transactions->pluck('id')->map(fn($id) => (string)$id);

        }else{

            $this->selected = [];

        }

    }

    public function updatedSelected(){

        $this->selectAll = false;

    }

    public function selectAllItems(){

        $this->selectAll = true;

    }

    public function sortBy($field){

        if($this->sortField === $field){

            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';

        }else{

            $this->sortDirection = 'asc';

        }

        $this->sortField = $field;

    }

    public function edit(Transaction $transaction){

        if($this->editing->isNot($transaction))
            $this->makeBlankModel();

        $this->editing = $transaction;

        $this->showEditModal = true;

    }

    public function save(){

        $this->validate();

        $this->editing->save();

        $this->showEditModal = false;

    }

    public function create(){

        if($this->editing->getKey())
            $this->makeBlankModel();

        $this->showEditModal = true;

    }

    public function delete(){

        (clone $this->transactionsQuery)
            ->unless($this->selectAll, fn($q) => $q->whereKey($this->selected))
            ->delete();

        $this->showDeleteModal = false;

    }

    public function makeBlankModel(){
        $this->editing = Transaction::make();
    }

    public function resetFilters(){

        $this->reset('filters');

    }

    public function getTransactionsQueryProperty(){

        return Transaction::query()
                            ->when($this->filters['search'], fn($q, $search) => $q->where('title', 'like', '%' . $search . '%'))
                            ->when($this->filters['status'], fn($q, $status) => $q->where('status', $status))
                            ->when($this->filters['amount-min'], fn($q, $amount) => $q->where('amount', '>=', $amount))
                            ->when($this->filters['amount-max'], fn($q, $amount) => $q->where('amount', '<=', $amount))
                            ->when($this->filters['date-min'], fn($q, $date) => $q->where('date', '>=', Carbon::createFromFormat('d/m/Y', $date)))
                            ->when($this->filters['date-max'], fn($q, $date) => $q->where('date', '<=', Carbon::createFromFormat('d/m/Y', $date)))
                            ->orderBy($this->sortField, $this->sortDirection);

    }

    public function getTransactionsProperty(){

        return $this->transactionsQuery->paginate(10);

    }

    public function mount(){

        $this->makeBlankModel();

    }

    #[Layout('components.layouts.base')]
    #[Title('Dashboard')]
    public function render()
    {

        if($this->selectAll){

            $this->selected = $this->transactions->pluck('id')->map(fn($id) => (string)$id);

        }

        return view('livewire.dashboard',[
            'transactions' => $this->transactions
        ]);
    }
}
