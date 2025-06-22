<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BallroomSpaceResource\Pages;
use App\Filament\Resources\BallroomSpaceResource\RelationManagers;
use App\Models\BallroomSpace;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BallroomSpaceResource extends Resource
{
    protected static ?string $model = BallroomSpace::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->helperText('Masukkan nama ruang ballroom dengan tepat.'),

                Forms\Components\FileUpload::make('thumbnail')
                ->image()
                ->required()
                ->helperText('Unggah gambar thumbnail ballroom'),


                Forms\Components\Textarea::make('about')
                ->required()
                ->rows(10)
                ->cols(20),

                Forms\Components\Repeater::make('photos')
                ->relationship('photos')
                ->schema([
                    Forms\Components\FileUpload::make('photo')
                    ->required(),
                ]),
                Forms\Components\Repeater::make('benefits')
                ->relationship('benefits')
                ->schema([
                    Forms\Components\TextInput::make('name')
                    ->required()
                ]),

                Forms\Components\Select::make('city_id')
                ->relationship('city', 'name')
                ->preload()
                ->required()
                ->searchable(),

                Forms\Components\TextInput::make('price')
                ->required()
                ->numeric()
                ->prefix('IDR'),

                Forms\Components\TextInput::make('duration')
                ->required()
                ->numeric()
                ->prefix('Days'),

                Forms\Components\Select::make('id_open')
                ->options([
                    true => 'Open',
                    false => 'Closed',
                ])
                ->required(),

                Forms\Components\Select::make('is_booked')
                ->options([
                    true => 'Booked',
                    false => 'Available',
                ])
                ->required()

            ]);
    }
        Public static function table(Table $table): Table
        { return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBallroomSpaces::route('/'),
            'create' => Pages\CreateBallroomSpace::route('/create'),
            'edit' => Pages\EditBallroomSpace::route('/{record}/edit'),
        ];
    }
}
