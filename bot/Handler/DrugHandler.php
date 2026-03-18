<?php
namespace Bot\Handler;

use App\Models\Drug;
use App\Models\DrugRelation;
use Bot\Chat\SearchElactanciaChat;
use Bot\Chat\SearchInteractionsChat;
use Bot\Chat\SearchReceiptsChat;
use Bot\Key\DrugKeyboard;
use SergiX44\Nutgram\Nutgram;

class DrugHandler extends Handler
{
    public function main(Nutgram $bot)
    {
        $method = $bot->isCallbackQuery() ? 'editMessageText' : 'sendMessage';

        $method($bot, __('drug.about_drugs'), 'html', DrugKeyboard::info());
    }

    public function check_receipts(Nutgram $bot)
    {
        editMessageText($bot, __('drug.check_receipt'), 'html', DrugKeyboard::back(), );

        $bot->stepConversation(new SearchReceiptsChat());
    }

    public function check_drug(Nutgram $bot, $id, $current, $ids)
    {
        $drug = Drug::find($id);
        $name = $drug->name;

        if ($id == $current) {
            return answerCallbackQuery($bot, __('drug.check_drug_alert', ['name' => mb_strtoupper($name)]), true);
        }

        $drugs = Drug::whereIn('id', explode(',', $ids))->get();

        editMessageText($bot, __('drug.check_drug_info', [
            'name_uppercase' => mb_strtoupper($name),
            'name_normal'    => $name,
            'description'    => $drug->description,
        ]), 'html', DrugKeyboard::checkList($drugs, $id));
    }

    public function drug_poly(Nutgram $bot, $ids)
    {
        $drugs = Drug::whereIn('id', explode(',', $ids))->get();

        editMessageText($bot, __('drug.check_drug_poly'), 'html', DrugKeyboard::checkList($drugs));
    }

    public function drug_compatibility(Nutgram $bot)
    {
        editMessageText($bot, __('drug.compatibility'), 'html', DrugKeyboard::back());

        $bot->stepConversation(new SearchInteractionsChat());
    }

    public function drug_safety(Nutgram $bot)
    {
        editMessageText($bot, __('drug.safety'), 'html', DrugKeyboard::back());

        $bot->stepConversation(new SearchElactanciaChat());
    }

    public function change_drugs(Nutgram $bot)
    {
        editMessageText($bot, __('drug.choose_category_change'), 'html', DrugKeyboard::changeCategory());
    }

    public function cancel_drugs(Nutgram $bot)
    {
        editMessageText($bot, __('drug.choose_category_cancel'), 'html', DrugKeyboard::cancelCategory());
    }

    public function category(Nutgram $bot, $type)
    {
        editMessageText($bot, __('drug.' . $type . '_primary', [
            'category' => __('button.' . $type),
        ]), 'html', DrugKeyboard::drugPrimary($type));
    }

    public function choose_drug(Nutgram $bot, $type, $primary_drug_id)
    {
        if ($type == 'stop_antidepressants') {
            $relation = DrugRelation::where('type', $type)
                ->where('primary_drug_id', $primary_drug_id)
                ->first();

            editMessageText($bot, __('drug.' . $type . '_info', [
                'category'     => __('button.' . $type),
                'primary_drug' => $relation->primaryDrug->name,

                'content1'     => htmlspecialchars($relation->metadata['content1']),
            ]), 'html', DrugKeyboard::backToChoose($relation));

            return;
        }

        $primary_drug = Drug::find($primary_drug_id);

        editMessageText($bot, __('drug.' . $type . '_secondary', [
            'category'     => __('button.' . $type),
            'primary_drug' => $primary_drug->name,
        ]), 'html', DrugKeyboard::drugSecondary($type, $primary_drug_id));
    }

    public function drug_info(Nutgram $bot, $type, $primary_drug_id, $secondary_drug_id)
    {
        $relation = DrugRelation::where('type', $type)
            ->where('primary_drug_id', $primary_drug_id)
            ->where('secondary_drug_id', $secondary_drug_id)
            ->first();

        if (empty($relation->metadata)) {
            editMessageText($bot, __('drug.relation_not_found'), 'html', DrugKeyboard::backToChoose($relation));
            return;
        }

        editMessageText($bot, __('drug.' . $type . '_info', [
            'category'       => __('button.' . $type),
            'primary_drug'   => $relation->primaryDrug->name,
            'secondary_drug' => $relation->secondaryDrug->name,

            'content1'       => htmlspecialchars($relation->metadata['content1']),
            'content2'       => htmlspecialchars($relation->metadata['content2']),
            'content3'       => htmlspecialchars($relation->metadata['content3']),
        ]), 'html', DrugKeyboard::backToChoose($relation));
    }
}
