<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\City;
use App\Models\Network;
use App\Models\Phone;
use App\Models\Province;
use Livewire\Component;

class Index extends Component
{
    public $countTotSMS = 0;
    public $countSendSMS = 0;
    public $countNotSendSMS = 0;

    public $province = 0;
    public $network = 0;
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
        $this->countSendSMS = Phone::where('is_submit', '=', true)->count();
        $this->countNotSendSMS = Phone::where('is_submit', '=', false)->count();
        $this->getSolde();
    }
    public function render()
    {
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
            'provinceCount' => $provinceCount,
            'networks' => Network::orderBy('name', 'ASC')->get(),
            'phones' => $phones,
            'phonesSend' => $phonesSend,
            'phonesNotSend' => $phonesNotSend,
            'cities' => City::where('province_id', '=', $this->province)->orderBy('name', 'ASC')->get(),
            'networks_filter' => Network::orderBy('name', 'ASC')->get(),
            'provinces' => Province::orderBy('name', 'ASC')->get(),
        ]);
    }
}
