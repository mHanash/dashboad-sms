<?php

namespace App\Http\Livewire\Import;

use App\Imports\ImportPhone;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Phone extends Component
{
    use WithFileUploads;

    public $file;

    protected $rules = [
        'file' => 'required'
    ];

    public function save(Request $request)
    {
        $this->validate();

        Excel::import(
            new ImportPhone,
            $this->file->store('phones')
        );
        $this->dispatchBrowserEvent('informed', [
            'msg' => 'Données chargées !',
            'title' => "L'importation des numéros a reussie"
        ]);
        $this->emit('pg:eventRefresh-default');
        $this->reset('file');
    }
    public function render()
    {
        return view('livewire.import.phone');
    }
}
