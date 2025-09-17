<?php

namespace App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource;

use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
      protected static string $resource = PageResource::class;
    public $content;

    protected function getFormSchema(): array
    {
        return [
            // tumhare fields yaha
        ];
    }

    public function mount($record): void
    {
        parent::mount($record);

        // Agar database se initial content load karna hai:
        $this->content = $record->content ?? '';
    }
}
