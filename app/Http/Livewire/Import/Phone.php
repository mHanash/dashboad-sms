<?php

namespace App\Http\Livewire\Import;

use App\Imports\ImportPhone;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Phone extends Component
{
    use WithFileUploads;

    public $file;

    public function save()
    {
        Excel::import(
            new ImportPhone,
            $this->file->store('phones')
        );
        $this->dispatchBrowserEvent('informed', [
            'msg' => 'Données chargées !',
            'title' => "L'importation des numéros a reussie"
        ]);
        $this->emit('pg:eventRefresh-default');
    }
    public function render()
    {
        return view('livewire.import.phone');
    }
}
