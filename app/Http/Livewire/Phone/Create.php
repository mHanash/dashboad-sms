<?php

namespace App\Http\Livewire\Phone;

use App\Models\City;
use App\Models\Network;
use App\Models\Phone;
use App\Models\Province;
use Livewire\Component;

class Create extends Component
{
    public string $number = '';
    public int $city = 0;
    public int $network = 0;
    public int $province = 0;


    protected $rules = [
        'number' => 'required',
        'city' => 'required',
        'network' => 'required',
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
        Phone::create([
            'number' => $this->number,
            'city_id' => $this->city,
            'network_id' => $this->network,
        ]);
        $this->emit('pg:eventRefresh-default');
        $this->reset('number');
    }

    public function destroy($item)
    {
        $city = Phone::find($item);
        $city->delete();
        $this->emit('pg:eventRefresh-default');
    }
    public function render()
    {
        return view('livewire.phone.create', [
            'provinces' => Province::all(),
            'cities' => City::where('province_id', '=', $this->province)->orderBy('name', 'ASC')->get(),
            'networks' => Network::orderBy('name', 'ASC')->get()
        ]);
    }
}
