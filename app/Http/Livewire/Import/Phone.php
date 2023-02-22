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
        'file' => 'required|file'
    ];

    public function save()
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
    public function mount()
    {
        ini_set('max_upload_size', '100M');
    }
    public function render()
    {
        return view('livewire.import.phone');
    }
}
