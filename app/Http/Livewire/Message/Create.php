<?php

namespace App\Http\Livewire\Message;

use App\Models\City;
use App\Models\Network;
use App\Models\Phone;
use App\Models\Province;
use Infobip\Configuration;
use Livewire\Component;
use GuzzleHttp\Client;
use Infobip\Api\SendSmsApi;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Throwable;

class Create extends Component
{
    public string $title = '';
    public string $bodyMsg = '';
    public $phoneNumbers = [];

    public int $province = 0;
    public int $city = 0;
    public int $network = 0;

    public function save()
    {
        if (count($this->phoneNumbers) == 0) {
            session()->flash('message', 'Vous n\'avez pas sélectionné un numéro.');
            return $this;
        }

        $configuration = (new Configuration())
            ->setHost(env('URL_BASE_PATH'))
            ->setApiKeyPrefix('Authorization', env('API_KEY_PREFIX'))
            ->setApiKey('Authorization', env('API_KEY'));

        $client = new Client();


        $sendSmsApi = new SendSMSApi($client, $configuration);
        $destination = [];
        foreach ($this->phoneNumbers as $phone) {

            $destination[] = (new SmsDestination())->setTo($phone);
        }
        // $destination = (new SmsDestination())->setTo('243818674267');
        $message = (new SmsTextualMessage())
            ->setFrom($this->title)
            ->setText($this->bodyMsg)
            ->setDestinations($destination);
        $request = (new SmsAdvancedTextualRequest())
            ->setMessages([$message]);
        try {
            $smsResponse = $sendSmsApi->sendSmsMessage($request);
            $blockId = $smsResponse->getBulkId();
            $messageId = $smsResponse->getMessages()[0]->getMessageId();
            $this->dispatchBrowserEvent('informed', [
                'msg' => ($blockId) ? 'Détails : ' . $messageId : 'Détail :' . $messageId,
                'title' => "Message envoyé"
            ]);
        } catch (Throwable $apiException) {
            $this->dispatchBrowserEvent('error', ['data' => $apiException->getMessage()]);
        }
    }

    public function render()
    {

        $phones = [];
        if ($this->network && $this->city) {
            $phones = Phone::where('network_id', '=', $this->network)->where('city_id', '=', $this->city)->get();
        } elseif ($this->network) {
            $phones = Phone::where('network_id', '=', $this->network)->get();
        } elseif ($this->city) {
            $phones = Phone::where('city_id', '=', $this->city)->get();
        } else {
            $phones = Phone::all();
        }

        return view('livewire.message.create', [
            'phones' => $phones,
            'cities' => ($this->province) ? City::where('province_id', '=', $this->province)->get() : City::orderBy('name', 'ASC')->get(),
            'networks' => Network::orderBy('name', 'ASC')->get(),
            'provinces' => Province::orderBy('name', 'ASC')->get(),
        ]);
    }
}
