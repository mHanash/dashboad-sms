<?php

namespace App\Http\Livewire\Province;

use App\Models\Province;
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
        Province::create([
            'name' => $this->name
        ]);
        $this->emit('pg:eventRefresh-default');
        $this->reset('name');
    }

    public function destroy($item)
    {
        $province = Province::find($item);
        $province->delete();
        $this->emit('pg:eventRefresh-default');
    }
    public function render()
    {
        return view('livewire.province.create');
    }
}
