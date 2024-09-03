<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ByCategoryTable extends BaseWidget
{
    public function getTableRecordKey($record): string
    {
        // Ensure the key is a string to satisfy the return type
        return (string) $record->category_id;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaction::query()
                    ->select([
                        'category_id',
                        DB::raw('SUM(amount) as total'),
                    ])
                    ->where('date', '>=', now()->subDays(30))
                    ->whereNotNull('category_id')
                    ->groupBy('category_id')
                    ->orderBy('total', 'desc')
            )
            ->columns([
                TextColumn::make('category.name')
                    ->label('Category'),
                TextColumn::make('total')
                    ->label('Total')
            ])
            ->defaultSort('total', 'desc');
    }

    public function getLabel(): string
    {
        return 'By Category';
    }
}
