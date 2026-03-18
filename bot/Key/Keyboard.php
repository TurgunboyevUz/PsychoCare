<?php
namespace Bot\Key;

trait Keyboard
{
    public static function main()
    {
        return inlineKeyboard([
            ['text' => __('button.testing_disorders'), 'callback_data' => 'testing_disorders'],
            ['text' => __('button.daily_mood'), 'callback_data' => 'daily_mood'],
            ['text' => __('button.drug_info'), 'callback_data' => 'drug_info'],
            ['text' => __('button.contacts'), 'callback_data' => 'contacts'],
        ]);
    }

    public static function home()
    {
        return inlineKeyboard([
            ['text' => __('button.home'), 'callback_data' => 'home'],
        ]);
    }
}
