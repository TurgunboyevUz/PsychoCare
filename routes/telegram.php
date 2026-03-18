<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use Bot\Chat\EditMoodChat;
use Bot\Chat\TestingDisorderChat;
use Bot\Handler\DrugHandler;
use Bot\Handler\MainHandler;
use Bot\Handler\MoodHandler;
use Bot\Handler\QuestionHandler;
use Bot\Middleware\UserMiddleware;
use SergiX44\Nutgram\Nutgram;

$bot->onCommand('start', [MainHandler::class, 'start'])->middleware(UserMiddleware::class);
$bot->onCallbackQueryData('home', [MainHandler::class, 'home']);
$bot->onCallbackQueryData('contacts', [MainHandler::class, 'contacts']);

// ---------- Test ishlash ----------
$bot->onCommand('tests', [QuestionHandler::class, 'testing_disorders']);
$bot->onCallbackQueryData('testing_disorders', [QuestionHandler::class, 'testing_disorders']);

$bot->onCallbackQueryData('category:{id}', [QuestionHandler::class, 'category']);
$bot->onCallbackQueryData('test:{id}', TestingDisorderChat::class);

$bot->onCallbackQueryData('prev_results:{id}', [QuestionHandler::class, 'prev_results']);
$bot->onCallbackQueryData('result:{id}', [QuestionHandler::class, 'result']);
$bot->onCallbackQueryData('interpretation:{id}', [QuestionHandler::class, 'interpretation']);

// ---------- Nastroenie belgilash -----------
$bot->onCommand('mood', [MoodHandler::class, 'daily_mood']);
$bot->onCallbackQueryData('daily_mood', [MoodHandler::class, 'daily_mood']);
$bot->onCallbackQueryData('change_mood', [MoodHandler::class, 'change_mood']);

$bot->onCallbackQueryData('mood:{id}', [MoodHandler::class, 'choose_mood']);
$bot->onCallbackQueryData('change_to:{id}', [MoodHandler::class, 'change_to']);

$bot->onCallbackQueryData('rewrite_comment', [MoodHandler::class, 'rewrite_comment']);

$bot->onCallbackQueryData('make_graph', [MoodHandler::class, 'make_graph']);
$bot->onCallbackQueryData('mood_settings', [MoodHandler::class, 'settings']);

$bot->onCallbackQueryData('notifications', [MoodHandler::class, 'notifications']);
$bot->onCallbackQueryData('timezones', [MoodHandler::class, 'timezones']);
$bot->onCallbackQueryData('templates', [MoodHandler::class, 'templates']);

$bot->onCallbackQueryData('notification:{time}', [MoodHandler::class, 'notification']);
$bot->onCallbackQueryData('timezone:{utc}', [MoodHandler::class, 'timezone']);
$bot->onCallbackQueryData('toggle_template', [MoodHandler::class, 'toggle_template']);
$bot->onCallbackQueryData('set_default', [MoodHandler::class, 'set_default']);
$bot->onCallbackQueryData('edit:{id}', EditMoodChat::class);

// ----------------- DORILAR -----------------
$bot->onCommand('drugs', [DrugHandler::class, 'main']);
$bot->onCommand('drugs_menu', [DrugHandler::class, 'main']);
$bot->onCallbackQueryData('drug_info', [DrugHandler::class, 'main']);
$bot->onCallbackQueryData('check_receipts', [DrugHandler::class, 'check_receipts']);
$bot->onCallbackQueryData('check_drug:{id}:{current}:{ids}', [DrugHandler::class, 'check_drug']);
$bot->onCallbackQueryData('drug_poly:{ids}', [DrugHandler::class, 'drug_poly']);

$bot->onCallbackQueryData('drug_compatibility', [DrugHandler::class, 'drug_compatibility']);
$bot->onCallbackQueryData('drug_safety', [DrugHandler::class, 'drug_safety']);

$bot->onCallbackQueryData('change_drugs', [DrugHandler::class, 'change_drugs']);
$bot->onCallbackQueryData('cancel_drugs', [DrugHandler::class, 'cancel_drugs']);

$types = ['switch_antidepressants', 'switch_antipsychotics', 'combine_moodstabilizers', 'stop_antidepressants'];
$bot->onCallbackQueryData('drug:{type}', [DrugHandler::class, 'category'])->whereIn('type', $types);
$bot->onCallbackQueryData('drug:{type}:{primary_drug_id}', [DrugHandler::class, 'choose_drug'])->whereIn('type', $types)->whereNumber('primary_drug_id');
$bot->onCallbackQueryData('drug:{type}:{primary_drug_id}:{secondary_drug_id}', [DrugHandler::class, 'drug_info'])->whereIn('type', $types)->whereNumber('primary_drug_id')->whereNumber('secondary_drug_id');
