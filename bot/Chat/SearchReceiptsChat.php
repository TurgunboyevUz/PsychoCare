<?php
namespace Bot\Chat;

use App\Models\Drug;
use App\Services\DrugService;
use Bot\Key\DrugKeyboard;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class SearchReceiptsChat extends Conversation
{
    public function start(Nutgram $bot)
    {
        $names = (new DrugService)->parseDrugsList($bot->message()->text);

        $drugs = collect();

        foreach ($names as $name) {
            $drug = Drug::where('name', 'LIKE', "%{$name}%")->orWhereHas('aliases', fn($q) => $q->where('name', 'LIKE', "%{$name}%"))->first();

            if ($drug) {$drugs->add($drug);}
        }

        if ($drugs->isEmpty()) {
            return sendMessage($bot, __('drug.not_found'), 'html');
        }

        sendMessage($bot, __('drug.check_search_results'), 'html', DrugKeyboard::checkList($drugs->unique('id')));
    }
}
