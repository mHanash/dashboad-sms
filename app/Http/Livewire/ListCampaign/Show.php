<?php

namespace App\Http\Livewire\ListCampaign;

use App\Models\ListCampaign;
use Livewire\Component;

class Show extends Component
{
    public ListCampaign $list;
    protected $listeners = [
        'details' => 'show'
    ];
    public function show($id)
    {
        $this->list =  ListCampaign::find($id);
    }

    public function render()
    {
        return view('livewire.list-campaign.show');
    }
}
