<?php
namespace Bot\Chat;

use App\Models\Drug;
use App\Services\DrugService;
use App\Utils\GoogleTranslate;
use Bot\Key\DrugKeyboard;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class SearchElactanciaChat extends Conversation
{
    public function start(Nutgram $bot)
    {
        $message = sendMessage($bot, __('drug.wait_operation'), 'html');

        $drugs   = [];
        $service = new DrugService;
        foreach ($service->parseDrugsList($bot->message()->text) as $drug_name) {
            $drugs[] = $this->searchDrug($drug_name);
        }

        $message->delete();

        foreach ($drugs as $drug) {
            if (! $drug) {
                return sendMessage($bot, __('drug.not_found'), 'html', reply_to_message_id: $bot->messageId());
            }

            sendMessage($bot, __('drug.lactation', [
                'name'     => mb_ucfirst($drug['name']),
                'content1' => htmlspecialchars($drug['content1']),
                'content2' => htmlspecialchars($drug['content2']),
                'content3' => empty($drug['content3']) ? __('drug.no_alternatives') : htmlspecialchars($drug['content3']),
            ]), 'html', DrugKeyboard::checkLactation(), reply_to_message_id: $bot->messageId());
        }

        $bot->endConversation();
    }

    public function searchDrug($name)
    {
        $service = new DrugService;
        $drug    = Drug::whereHas('relations', function ($query) {
            $query->where('type', 'lactation');
        })->where(function ($query) use ($name) {
            $query->where('name', 'LIKE', "%{$name}%")->orWhereHas('aliases', fn($q) => $q->where('name', 'LIKE', "%{$name}%"));
        })->first();

        if (!$drug) {
            $url = $service->searchFromElactancia(GoogleTranslate::translate('auto', 'en', $name));

            if (! $url) {return false;}

            $data = $service->getFromElactancia($url);
            $drug = Drug::firstOrCreate(['name' => $name]);

            $relation = $drug->relations()->create([
                'type'     => 'lactation',
                'metadata' => $data,
            ]);
        }else{
            $relation = $drug->relations()->where('type', 'lactation')->first();
        }

        return array_merge($relation->metadata, ['name' => $drug->name]);
    }
}
