<?php

namespace App\Filament\Resources\BallroomSpaceResource\Pages;

use App\Filament\Resources\BallroomSpaceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBallroomSpace extends EditRecord
{
    protected static string $resource = BallroomSpaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
