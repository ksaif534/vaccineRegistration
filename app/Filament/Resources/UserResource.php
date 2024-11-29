<?php

namespace App\Filament\Resources;

use App\Enumerators\UserStatus;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\{TextConstraint,SelectConstraint};
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->rules(['string','max:511','required']),
                Forms\Components\TextInput::make('email')
                ->email()
                ->rules(['string','max:511','required']),
                Forms\Components\TextInput::make('phone_number')
                ->rules(['string','max:511','required']),
                Forms\Components\TextInput::make('nid')
                ->rules(['string','max:1023','required']),
                Forms\Components\TextInput::make('password')
                ->rules(['string','max:511','required'])
                ->password()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                ->searchable(),
                Tables\Columns\TextColumn::make('status')
                ->searchable(),
                Tables\Columns\TextColumn::make('vaccine_center.name')
                ->searchable(),
            ])
            ->filters([
                QueryBuilder::make()
                ->constraints([
                    SelectConstraint::make('status')
                    ->options([
                        'Scheduled'     => UserStatus::SCHEDULED->value,
                        'Not scheduled' => UserStatus::NOT_SCHEDULED->value,
                        'Vaccinated'    => UserStatus::VACCINATED->value
                    ]),
                    TextConstraint::make('vaccine_center.name')
                ])
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
