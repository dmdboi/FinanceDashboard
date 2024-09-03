<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Jobs\categorizeTrx;
use App\Models\Subscription;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Category;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('description')
                    ->label('Description')
                    ->placeholder('Enter a description')
                    ->required(),
                TextInput::make('amount')->type('number')
                    ->label('Amount')
                    ->placeholder('Enter an amount')
                    ->required(),
                Select::make('type')
                    ->label('Type')
                    ->placeholder('Select a type')
                    ->options(
                        [
                            'expense' => 'Expense',
                            'income' => 'Income',
                        ]
                    )
                    ->required(),
                Select::make('category_id')
                    ->label('Category')
                    ->placeholder('Select a category')
                    ->options(
                        Category::all()->pluck('name', 'id')
                    )
                    ->required(),
                Select::make('subscription_id')
                    ->label('Subscription')
                    ->placeholder('Select a subscription')
                    ->options(
                        Subscription::all()->pluck('name', 'id')
                    ),
                TextInput::make('trx_date')->type('date'),
                TextInput::make('note'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->formatStateUsing(fn(string $state): string => $state / 100)
                    ->searchable(),
                IconColumn::make('type')
                    ->label('Type')
                    ->icon(fn(string $state): string => match ($state) {
                        'expense' => 'heroicon-o-arrow-down',
                        'income' => 'heroicon-o-arrow-up',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'expense' => 'danger',
                        'income' => 'success',
                    })
                    ->size(IconColumn\IconColumnSize::Small)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('trx_date')
                    ->label('Date')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
                SelectFilter::make('type')
                    ->label('Type')
                    ->options([
                        'expense' => 'Expense',
                        'income' => 'Income',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('trx_date', 'desc')
            ->headerActions([
                Action::make('processTransactions')
                    ->form([
                        TextInput::make('Since date')->type('date')
                    ])
                    ->action(function (array $data) {
                        $sinceDate = $data['Since date'];
                        $trxs = Transaction::where('trx_date', '>=', $sinceDate)->get();

                        foreach ($trxs as $trx) {
                            categorizeTrx::dispatch($trx);
                        }
                    })
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
