<?php

namespace Filament\Admin\Resources\Broadcasts\Pages;

use Filament\Admin\Resources\Broadcasts\BroadcastResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBroadcast extends CreateRecord
{
    protected static string $resource = BroadcastResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
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
