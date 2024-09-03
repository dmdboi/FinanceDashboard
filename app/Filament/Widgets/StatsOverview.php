<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Spatie\FilamentSimpleStats\SimpleStat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $last30days = Transaction::where('trx_date', '>=', now()->subDays(30));

        return [
            //
            Card::make('Total Transactions', $last30days->count())
                ->icon('heroicon-o-currency-dollar'),
            Card::make('Expenses', $last30days->where('type', 'expense')->sum('amount') / 100)
                ->icon('heroicon-o-currency-dollar'),
            Card::make('Income', $last30days->where('type', 'income')->sum('amount') / 100)
                ->icon('heroicon-o-currency-dollar'),
        ];
    }
}
