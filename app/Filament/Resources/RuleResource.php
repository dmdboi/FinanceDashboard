<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RuleResource\Pages;
use App\Filament\Resources\RuleResource\RelationManagers;
use App\Models\Rule;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Category;

class RuleResource extends Resource
{
    protected static ?string $model = Rule::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('property')
                    ->label('Property')
                    ->placeholder('Enter a property')
                    ->required(),
                Select::make('oeprator')
                    ->label('Operator')
                    ->placeholder('Select an operator')
                    ->options(
                        [
                            'equals' => 'Equals',
                            'does_not_equal' => 'Does not equal',
                            'is_greater_than' => 'Is greater than',
                            'is_less_than' => 'Is less than',
                            'contains' => 'Contains',
                            'does_not_contain' => 'Does not contain',
                            'starts_with' => 'Starts with',
                            'ends_with' => 'Ends with',
                        ]
                    )
                    ->required(),
                TextInput::make('value')
                    ->label('Value')
                    ->placeholder('Enter a value')
                    ->required(),
                Select::make('category_id')
                    ->label('Category')
                    ->placeholder('Select a category')
                    ->options(
                        Category::all()->pluck('name', 'id')
                    )
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('property')
                    ->label('Property'),
                Tables\Columns\TextColumn::make('operator')
                    ->label('Operator'),
                Tables\Columns\TextColumn::make('value')
                    ->label('Value'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category'),
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
            'index' => Pages\ListRules::route('/'),
            'create' => Pages\CreateRule::route('/create'),
            'edit' => Pages\EditRule::route('/{record}/edit'),
        ];
    }
}
