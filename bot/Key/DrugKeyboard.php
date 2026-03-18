<?php
namespace Bot\Key;

use App\Models\DrugRelation;

class DrugKeyboard
{
    public static function info()
    {
        return inlineKeyboard(array_merge([
            ['text' => __('button.check_receipts'), 'callback_data' => 'check_receipts'],
            ['text' => __('button.change_drugs'), 'callback_data' => 'change_drugs'],
            ['text' => __('button.drug_compatibility'), 'callback_data' => 'drug_compatibility'],
            ['text' => __('button.drug_safety'), 'callback_data' => 'drug_safety'],
            ['text' => __('button.cancel_drugs'), 'callback_data' => 'cancel_drugs'],
            ['text' => __('button.home'), 'callback_data' => 'home'],
        ]));
    }

    public static function back()
    {
        return inlineKeyboard([
            ['text' => __('button.back'), 'callback_data' => 'drug_info'],
            ['text' => __('button.home'), 'callback_data' => 'home'],
        ]);
    }

    public static function checkList($drugs, $current = 0)
    {
        $ids      = implode(',', $drugs->pluck('id')->toArray());
        $keyboard = [];

        $i = 1;

        foreach ($drugs as $drug) {
            $name = $drug->name;

            $keyboard[] = ['text' => ($current == $drug->id ? '👉 ' : '') . $name, 'callback_data' => 'check_drug:' . $drug->id . ':' . $current . ':' . $ids];

            if ($i == 5) {
                $keyboard[] = ['text' => 'ПОЛИПРАГМАЗИЯ', 'callback_data' => 'drug_poly:' . $ids];
                break;
            }

            $i++;
        }

        $keyboard   = array_chunk($keyboard, 3);
        $keyboard[] = ['text' => __('button.back'), 'callback_data' => 'drug_info'];

        return inlineKeyboard($keyboard);
    }

    public static function changeCategory()
    {
        return inlineKeyboard([
            ['text' => __('button.switch_antidepressants'), 'callback_data' => 'drug:switch_antidepressants'],
            ['text' => __('button.switch_antipsychotics'), 'callback_data' => 'drug:switch_antipsychotics'],
            ['text' => __('button.combine_moodstabilizers'), 'callback_data' => 'drug:combine_moodstabilizers'],
            ['text' => __('button.back'), 'callback_data' => 'drug_info'],
            ['text' => __('button.home'), 'callback_data' => 'home'],
        ]);
    }

    public static function cancelCategory()
    {
        return inlineKeyboard([
            ['text' => __('button.stop_antidepressants'), 'callback_data' => 'drug:stop_antidepressants'],
            ['text' => __('button.back'), 'callback_data' => 'drug_info'],
            ['text' => __('button.home'), 'callback_data' => 'home'],
        ]);
    }

    public static function drugPrimary($type)
    {
        $keyboard = [];
        $drugs    = DrugRelation::where('type', $type)->get()->unique('primary_drug_id');
        $backTo   = in_array($type, ['switch_antidepressants', 'switch_antipsychotics', 'combine_moodstabilizers']) ? 'change_drugs' : 'cancel_drugs';

        foreach ($drugs as $item) {
            $keyboard[] = ['text' => $item->primaryDrug->name, 'callback_data' => 'drug:' . $type . ':' . $item->primary_drug_id];
        }

        $keyboard   = array_chunk($keyboard, 3);
        $keyboard[] = ['text' => __('button.back'), 'callback_data' => $backTo];
        $keyboard[] = ['text' => __('button.home'), 'callback_data' => 'home'];

        return inlineKeyboard($keyboard);
    }

    public static function drugSecondary($type, $primary_drug_id)
    {
        $keyboard = [];
        $backTo   = 'drug:' . $type;

        $drugs = DrugRelation::where('type', $type)->where('primary_drug_id', $primary_drug_id)->get();

        foreach ($drugs as $item) {
            $keyboard[] = ['text' => $item->secondaryDrug->name, 'callback_data' => 'drug:' . $type . ':' . $item->primary_drug_id . ':' . $item->secondary_drug_id];
        }

        $keyboard   = array_chunk($keyboard, 3);
        $keyboard[] = ['text' => __('button.back'), 'callback_data' => $backTo];
        $keyboard[] = ['text' => __('button.home'), 'callback_data' => 'home'];

        return inlineKeyboard($keyboard);
    }

    public static function backToChoose(DrugRelation $relation)
    {
        return inlineKeyboard([
            ['text' => __('button.back'), 'callback_data' => 'drug:' . $relation->type . ($relation->secondary_drug_id != null ? ':' . $relation->primary_drug_id : '')],
            ['text' => __('button.home'), 'callback_data' => 'home'],
        ]);
    }

    public static function checkLactation()
    {
        return inlineKeyboard([
            ['text' => __('button.check_lactation'), 'callback_data' => 'drug_safety'],
            ['text' => __('button.back'), 'callback_data' => 'drug_info'],
        ]);
    }

    public static function checkCompatibility()
    {
        return inlineKeyboard([
            ['text' => __('button.check_compatibility'), 'callback_data' => 'drug_compatibility'],
            ['text' => __('button.back'), 'callback_data' => 'drug_info'],
        ]);
    }
}
