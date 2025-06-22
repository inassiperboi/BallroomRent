<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingTransactionResource\Pages;
use App\Filament\Resources\BookingTransactionResource\RelationManagers;
use App\Models\BookingTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingTransactionResource extends Resource
{
    protected static ?string $model = BookingTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                // Forms\Components\TextInput::make('booking_trx_id')
                //     ->required()
                //     ->maxLength(255)
                //     ->label('Booking Code'),

                    Forms\Components\TextInput::make('phone_number')
                    ->required()
                    ->maxLength(255),

                    Forms\Components\TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->prefix('IDR'),

                    Forms\Components\TextInput::make('duration')
                    ->required()
                    ->numeric()
                    ->suffix('Days'),

                    Forms\Components\DateTimePicker::make('started_at')
                    ->required(),

                    Forms\Components\DateTimePicker::make('ended_at')
                    ->required(),

                    Forms\Components\Select::make('is_paid')
                    ->options([
                        true => 'Paid',
                        false => 'Unpaid',
                    ])
                    ->required(),

                    Forms\Components\Select::make('ballroomspace_id')
                    ->relationship('ballroomspace', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('booking_trx_id')
                    ->label('Booking Code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ballroomspace.name')
                    ->label('Ballroom Space')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->prefix('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->suffix('Days')
                    ->sortable(),
                Tables\Columns\TextColumn::make('started_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ended_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_paid')
                    ->boolean()
                    ->label('Payment Status')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),
            ])
            ->filters([
                //
                Tables\Filters\Filter::make('paid')
                    ->query(fn (Builder $query) => $query->where('is_paid', true))
                    ->label('Paid Transactions'),
                Tables\Filters\Filter::make('unpaid')
                    ->query(fn (Builder $query) => $query->where('is_paid', false))
                    ->label('Unpaid Transactions'),
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
            'index' => Pages\ListBookingTransactions::route('/'),
            'create' => Pages\CreateBookingTransaction::route('/create'),
            'edit' => Pages\EditBookingTransaction::route('/{record}/edit'),
        ];
    }
}
