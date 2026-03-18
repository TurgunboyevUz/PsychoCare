<?php
namespace Bot\Chat;

use App\Models\Drug;
use App\Models\DrugRelation;
use App\Services\DrugService;
use App\Utils\GoogleTranslate;
use Bot\Key\DrugKeyboard;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class SearchInteractionsChat extends Conversation
{
    public function start(Nutgram $bot)
    {
        $text = $bot->message()->text;

        $service = new DrugService;
        $drugs   = $service->parseDrugsList($text);

        $message = sendMessage($bot, __('drug.wait_operation'), 'html');

        $interactions = $this->searchInteraction($drugs);

        $message->delete();

        if (! $interactions) {
            return sendMessage($bot, __('drug.not_found'), reply_to_message_id: $bot->messageId());
        }

        $i                  = 1;
        $compatibility_list = '';

        foreach ($interactions as $key => $result) {
            $compatibility_list .= "\n\n" . __('drug.compatibility_item', [
                'label'       => __('button.num_' . ($i)),
                'item'        => $key,
                'description' => $result,
            ]);

            $i++;
        }

        sendMessage($bot, __('drug.compatibility_info', [
            'compatibility_list' => trim($compatibility_list),
        ]), 'html', DrugKeyboard::checkCompatibility(), reply_to_message_id: $bot->messageId());

        $bot->endConversation();
    }

    public function searchInteraction($drug_names)
    {
        $drugs = array_map(fn($name) => (Drug::where('name', 'like', '%' . $name . '%')->first())?->id, $drug_names);

        if (in_array(null, $drugs) === false) {
            sort($drugs);
            $interaction = DrugRelation::where('drug_list', implode('-', $drugs))->first();

            if ($interaction) {
                return $interaction->metadata;
            }
        }

        $service  = new DrugService;
        $drugs_en = array_map(fn($value) => GoogleTranslate::translate('auto', 'en', $value), $drug_names);
        $drugs    = array_map(fn($value) => $service->searchFromDrugs($value), $drugs_en);
        $drugs    = array_filter($drugs);

        $interactions = $service->getFromDrugs(implode(',', $drugs));
        if (! is_array($interactions) or empty($interactions)) {return false;}

        $drugs = array_map(fn($name) => (Drug::firstOrCreate(['name' => $name]))->id, $drug_names);
        
        sort($drugs);

        DrugRelation::create([
            'type'      => 'interaction',
            'drug_list' => implode('-', $drugs),
            'metadata'  => $interactions,
        ]);

        return $interactions;
    }
}
