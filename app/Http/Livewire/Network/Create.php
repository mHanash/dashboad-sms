<?php

namespace App\Http\Livewire\Network;

use App\Models\Network;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';

    protected $rules = [
        'name' => 'required'
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
        Network::create([
            'name' => $this->name
        ]);
        $this->emit('pg:eventRefresh-default');
        $this->reset('name');
    }

    public function destroy($item)
    {
        $network = Network::find($item);
        $network->delete();
        $this->emit('pg:eventRefresh-default');
    }
    public function render()
    {
        return view('livewire.network.create');
    }
}
