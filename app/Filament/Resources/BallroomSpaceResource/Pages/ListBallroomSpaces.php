<?php

namespace App\Filament\Resources\BallroomSpaceResource\Pages;

use App\Filament\Resources\BallroomSpaceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBallroomSpaces extends ListRecords
{
    protected static string $resource = BallroomSpaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
