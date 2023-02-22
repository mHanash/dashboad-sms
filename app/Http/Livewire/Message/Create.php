<?php

namespace App\Http\Livewire\Message;

use App\Jobs\UpdatePhone;
use App\Models\Campaign;
use App\Models\City;
use App\Models\ListCampaign;
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
    public $listId = 0;

    public int $campaign = 0;

    public function save()
    {
        if ($this->listId == 0) {
            session()->flash('message', 'Vous n\'avez pas sélectionné une liste.');
            return $this;
        }

        $configuration = (new Configuration())
            ->setHost(env('URL_BASE_PATH'))
            ->setApiKeyPrefix('Authorization', env('API_KEY_PREFIX'))
            ->setApiKey('Authorization', env('API_KEY'));

        $client = new Client();


        $sendSmsApi = new SendSMSApi($client, $configuration);
        $destination = [];
        $list = ListCampaign::find($this->listId);
        foreach ($list->phones as $phone) {
            if (!$phone->pivot->is_submit) {
                $destination[] = (new SmsDestination())->setTo($phone->number);
            }
        }
        $smsResponse = [];
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
            $this->dispatchBrowserEvent('error', ['data' => 'Code : ' . $apiException->getCode() . ', Message :' . substr($apiException->getMessage(), 0, 20) . '...']);
        }
        if ($smsResponse) {
            foreach ($smsResponse->getMessages() as $value) {
                $item = Phone::where('number', '=', $value['to'])->first();
                $list->phones()->syncWithoutDetaching([
                    $item->id => ['is_submit' => true]
                ]);
            }
        }
        $this->reset('listId');
        $this->reset('campaign');
    }
    public function render()
    {
        $countList = 0;
        $list = '';
        if ($this->listId) {
            $list = ListCampaign::find($this->listId);
            $phones = $list->phones()->wherePivot('is_submit', '=', false)->get();
            $countList = count($phones);
        }
        $listCampaigns = ListCampaign::where('campaign_id', '=', $this->campaign)->orderBy('description', 'ASC')->get();
        return view('livewire.message.create', [
            'listName' => $list ? $list->description : '',
            'countList' => $countList,
            'campaigns' => Campaign::all(),
            'listCampaigns' => $listCampaigns
        ]);
    }
}
