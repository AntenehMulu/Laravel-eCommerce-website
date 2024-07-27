<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\RelationManagers\OrdersRelationManager;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use Filament\Actions\ViewAction;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                            ->required(),
                TextInput::make('email')
                        ->label('email Address')
                        ->email()
                        ->maxLength(255)
                        ->unique(ignoreRecord:true)
                        ->required(),
                DatePicker::make('email_verified_at')
                    ->label('Email Verified at')
                    ->default(now()),
                TextInput::make('password')
                ->password()
                ->dehydrated(fn($state)=>filled($state))
                ->required(fn (Page $livewire) => $livewire instanceof CreateRecord)
                        //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->searchable(),
                TextColumn::make('email')
                ->searchable(),
                TextColumn::make('email_verified_at')
                ->dateTime()
                ->searchable(),
                TextColumn::make('created_at')
                ->dateTime()
                ->sortable()


                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            OrdersRelationManager::class
        ];
    }
    public static function getGloballySearchableAttributes(): array
{
    return ['name', 'email'];
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
