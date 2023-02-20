<?php

namespace App\Http\Livewire\Import;

use App\Imports\ImportProvince;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Province extends Component
{
    use WithFileUploads;

    public $file;

    public function save()
    {
        Excel::import(
            new ImportProvince,
            $this->file->store('provinces')
        );
        $this->dispatchBrowserEvent('informed', [
            'msg' => 'Données chargées !',
            'title' => "L'importation des provinces a reussie"
        ]);
        $this->emit('pg:eventRefresh-default');
    }
    public function render()
    {
        return view('livewire.import.province');
    }
}
