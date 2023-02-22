<?php

namespace App\Http\Livewire\Campaign;

use App\Models\Campaign;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';

    protected $rules = [
        'name' => 'required'
    ];

    protected $listeners = [
        'deleteConfirmed' => 'destroy',
        'deleted' => 'delete',
        'listingEvent' => 'listing',
    ];


    public function listing($id)
    {
        $this->dispatchBrowserEvent('listing', $id);
    }
    public function delete($id)
    {
        $this->dispatchBrowserEvent('deleted', $id);
    }
    public function save()
    {
        $this->validate();
        Campaign::create([
            'name' => $this->name
        ]);
        $this->emit('pg:eventRefresh-default');
        $this->dispatchBrowserEvent('success', ['msg' => 'Campagne ' . $this->name . ' créée !']);
        $this->reset('name');
    }

    public function destroy($item)
    {
        $province = Campaign::find($item);
        $province->delete();
        $this->emit('pg:eventRefresh-default');
    }
    public function render()
    {
        return view('livewire.campaign.create');
    }
}
