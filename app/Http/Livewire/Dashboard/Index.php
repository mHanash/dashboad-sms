<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Campaign;
use App\Models\City;
use App\Models\ListCampaign;
use App\Models\Network;
use App\Models\Phone;
use App\Models\Province;
use Livewire\Component;

class Index extends Component
{
    public $countTotPhones = 0;
    public $countSendSMS = 0;
    public $countNotSendSMS = 0;
    public $countCampaign = 0;

    public $province = 0;
    public $list = 0;
    public $networklist = 0;
    public $network = 0;
    public $campaign = 0;
    public $city = 0;
    public $solde = 0;
    public $responseSolde = [];

    public function getSolde()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('URL_BASE_PATH') . '/account/1/balance',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization:' . env('API_KEY_PREFIX') . ' ' . env('API_KEY'),
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $balance = json_decode($response, true);

        if (curl_error($curl)) {
            $this->dispatchBrowserEvent('informed', [
                'msg' => 'Erreur : ' . curl_error($curl),
                'title' => "Pas possible de recupérer le solde"
            ]);
            $this->responseSolde = [
                'Erreur' => curl_error($curl)
            ];
        } else {
            $this->solde = $balance['balance'];
            $this->responseSolde = $balance;
        }
        curl_close($curl);
    }
    public function mount()
    {
        $this->countCampaign = Campaign::count();
        $this->countTotPhones = Phone::count();
        $this->getSolde();
    }
    public function render()
    {

        $phonesListSend = 0;
        $phonesListNotSend = 0;
        $phonesListTot = 0;
        if ($this->campaign) {
            $phonesListTot = Campaign::find($this->campaign)->lists()->count();
        }
        if ($this->list) {
            $list = ListCampaign::find($this->list);
            $phonesListSend += $list->phones()->where('network_id', '=', $this->networklist)->wherePivot('is_submit', '=', true)->count();
            $phonesListNotSend += $list->phones()->where('network_id', '=', $this->networklist)->wherePivot('is_submit', '=', false)->count();
        }
        $phones = [];
        $phones = Phone::where('city_id', '=', $this->city)->where('network_id', '=', $this->network)->get();
        $phonesSend = [];
        $phonesNotSend = [];
        $provinceCount = 0;
        if ($this->province) {
            $province = Province::find($this->province);
            $provinceCount = 0;
            foreach ($province->cities as $value) {
                $provinceCount += count($value->phones()->where('network_id', '=', $this->network)->get());
            }
        }
        foreach ($phones as $item) {
            if ($item->is_submit) {
                $phonesSend[] = $item;
            } else {
                $phonesNotSend[] = $item;
            }
        }
        return view('livewire.dashboard.index', [
            'phonesListTot' => $phonesListTot,
            'phonesListSend' => $phonesListSend,
            'phonesListNotSend' => $phonesListNotSend,
            'provinceCount' => $provinceCount,
            'networks' => Network::orderBy('name', 'ASC')->get(),
            'phones' => $phones,
            'phonesSend' => $phonesSend,
            'phonesNotSend' => $phonesNotSend,
            'campaigns' => Campaign::orderBy('name', 'ASC')->get(),
            'listCampaigns' => ListCampaign::where('campaign_id', '=', $this->campaign)->get(),
            'networks_filter' => Network::orderBy('name', 'ASC')->get(),
            'cities' => City::where('province_id', '=', $this->province)->orderBy('name', 'ASC')->get(),
            'provinces' => Province::orderBy('name', 'ASC')->get(),
        ]);
    }
}
