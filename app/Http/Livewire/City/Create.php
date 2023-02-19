<?php

namespace App\Http\Livewire\City;

use App\Models\City;
use App\Models\Province;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';
    public int $province = 0;


    protected $rules = [
        'name' => 'required',
        'province' => 'required'
    ];

    protected $listeners = [
        'deleteConfirmed' => 'destroy',
        'deleted' => 'delete'
    ];

    public function delete($id)
    {
        $this->dispatchBrowserEvent('deleted', $id);
    }
    public function save()
    {
        $this->validate();
        City::create([
            'name' => $this->name,
            'province_id' => $this->province,
        ]);
        $this->emit('pg:eventRefresh-default');
        $this->reset('name');
    }

    public function destroy($item)
    {
        $city = City::find($item);
        $city->delete();
        $this->emit('pg:eventRefresh-default');
    }
    public function render()
    {
        return view('livewire.city.create', [
            'provinces' => Province::orderBy('name', 'ASC')->get()
        ]);
    }
}
