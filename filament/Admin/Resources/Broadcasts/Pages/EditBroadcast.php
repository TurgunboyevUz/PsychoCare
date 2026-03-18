<?php
namespace Filament\Admin\Resources\Broadcasts\Pages;

use Filament\Actions\DeleteAction;
use Filament\Admin\Resources\Broadcasts\BroadcastResource;
use Filament\Resources\Pages\EditRecord;
use Nutgram\Laravel\Facades\Telegram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

class EditBroadcast extends EditRecord
{
    protected static string $resource = BroadcastResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function mutateFormDataBeforeSave(array $data): array
    {
        $allowed_tags = '<b><strong><i><em><u><ins><s><strike><del><tg-spoiler><span><a><code><pre><blockquote><tg-emoji><br>';

        $content = $data['content'];
        $content = str_replace(['<p>', '</p>', '<br>'], ['', "\n\n", "\n"], $content);
        $content = strip_tags($content, $allowed_tags);

        $data['content'] = $content;
        unset($data['media_type']);

        return $data;
    }
}
