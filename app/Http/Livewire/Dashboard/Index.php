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
        $this->countSendSMS = count(Phone::where('is_submit', '=', true)->get());
        $this->countNotSendSMS = count(Phone::where('is_submit', '=', false)->get());
        $this->getSolde();
    }
    public function render()
    {
        $phones = [];
        $phonesSend = [];
        $phonesNotSend = [];
        if ($this->network && $this->city) {
            $phonesSend = Phone::where('network_id', '=', $this->network)->where('city_id', '=', $this->city)->where('is_submit', '=', true)->get();
            $phonesNotSend = Phone::where('network_id', '=', $this->network)->where('city_id', '=', $this->city)->where('is_submit', '=', false)->get();
            $phones =  Phone::where('network_id', '=', $this->network)->where('city_id', '=', $this->city)->get();
        } elseif ($this->network) {
            $phonesSend = Phone::where('network_id', '=', $this->network)->where('is_submit', '=', true)->get();
            $phonesNotSend = Phone::where('network_id', '=', $this->network)->where('is_submit', '=', false)->get();
            $phones =  Phone::where('network_id', '=', $this->network)->get();
        } elseif ($this->city) {
            $phonesSend = Phone::where('city_id', '=', $this->city)->where('is_submit', '=', true)->get();
            $phonesNotSend = Phone::where('city_id', '=', $this->city)->where('is_submit', '=', false)->get();
            $phones =  Phone::where('city_id', '=', $this->city)->get();
        } else {
            $phonesSend = Phone::where('is_submit', '=', true)->get();
            $phonesNotSend = Phone::where('is_submit', '=', false)->get();
            $phones =  Phone::all();
        }
        return view('livewire.dashboard.index', [
            'networks' => Network::orderBy('name', 'ASC')->get(),
            'phones' => $phones,
            'phonesSend' => $phonesSend,
            'phonesNotSend' => $phonesNotSend,
            'cities' => ($this->province) ? City::where('province_id', '=', $this->province)->get() : City::orderBy('name', 'ASC')->get(),
            'networks_filter' => Network::orderBy('name', 'ASC')->get(),
            'provinces' => Province::orderBy('name', 'ASC')->get(),
        ]);
    }
}
