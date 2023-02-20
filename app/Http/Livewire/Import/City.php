<?php

namespace App\Http\Livewire\Import;

use App\Imports\ImportCity;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class City extends Component
{

    use WithFileUploads;

    public $file;
    protected $rules = [
        'file' => 'required'
    ];
    public function save()
    {
        $this->validate();
        Excel::import(
            new ImportCity,
            $this->file->store('cities')
        );
        $this->dispatchBrowserEvent('informed', [
            'msg' => 'Données chargées !',
            'title' => "L'importation des villes a reussie"
        ]);
        $this->emit('pg:eventRefresh-default');
        $this->reset('file');
    }
    public function render()
    {
        return view('livewire.import.city');
    }
}
