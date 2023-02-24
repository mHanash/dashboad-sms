<?php

namespace App\Http\Livewire\ListCampaign;

use App\Models\Campaign;
use App\Models\City;
use App\Models\ListCampaign;
use App\Models\Network;
use App\Models\Phone;
use App\Models\Province;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;
    public string $description = '';
    public $phoneNumbers = [];
    public $datas = [];
    public Campaign $campaign;
    public int $province = 0;
    public int $city = 0;
    public int $network = 0;

    protected $paginationTheme = 'bootstrap';
    protected $rules = [
        'description' => 'required'
    ];

    protected $listeners = [
        'deleteConfirmed' => 'destroy',
        'deleted' => 'delete',
        'show' => 'show'
    ];

    public function show($id)
    {
        $this->dispatchBrowserEvent('showModal', $id);
    }
    public function delete($id)
    {
        $this->dispatchBrowserEvent('deletedlist', $id);
    }
    public function save()
    {
        if (count($this->phoneNumbers) == 0) {
            $this->dispatchBrowserEvent('informed', ['msg' => 'La liste ne contient pas de numeros, veuillez ajouter.', 'title' => 'Erreur']);
            return $this;
        }
        $this->validate();
        if ($list = ListCampaign::create([
            'description' => $this->description,
            'campaign_id' => $this->campaign->id,
        ])) {
            $list->phones()->sync($this->phoneNumbers);
            $this->emit('pg:eventRefresh-default');
            $this->dispatchBrowserEvent('success', ['msg' => 'Liste ' . $this->description . ' créée !']);
            $this->reset('description');
            $this->reset('phoneNumbers');
        }
    }

    public function selectChange()
    {
        foreach ($this->datas as $value) {
            $exist = false;
            $index = 0;
            foreach ($this->phoneNumbers as $key => $val) {
                if ($value == $val) {
                    $exist = true;
                    $index = $key;
                }
            }
            if (!$exist) {
                $this->phoneNumbers[] = $value;
            } else {
                unset($this->phoneNumbers[$index]);
            }
        }
        $this->reset('datas');
    }

    public function destroy($item)
    {
        $list = ListCampaign::find($item);
        $list->phones()->detach();
        $list->delete();
        $this->emit('pg:eventRefresh-default');
    }
    public function render()
    {
        $phones = [];
        ini_set('max_execution_time', 180);
        $phones = Phone::where('city_id', '=', $this->city)->where('network_id', '=', $this->network)->paginate(100);
        return view('livewire.list-campaign.create', [
            'phones' => $phones,
            'cities' => City::where('province_id', '=', $this->province)->orderBy('name', 'ASC')->get(),
            'networks' => Network::orderBy('name', 'ASC')->get(),
            'provinces' => Province::orderBy('name', 'ASC')->get(),
        ]);
    }
}
