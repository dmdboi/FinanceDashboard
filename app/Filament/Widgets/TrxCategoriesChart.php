<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Transaction;
use Filament\Widgets\ChartWidget;

use Illuminate\Support\Facades\DB;

class TrxCategoriesChart extends ChartWidget
{
    protected static ?string $heading = 'By Category';

    protected function getData(): array
    {

        // Fetch all transactions within the last 30 days with their category if they have one, grouped by category with the sum of the amount column
        $trx = Transaction::where('date', '>=', now()->subDays(30))
            ->with('category')
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->select('category_id', DB::raw('sum(amount / 100) as sum'))
            ->get();

        return [
            //
            'labels' => $trx->pluck('category.name')->toArray(),
            'datasets' => [
                [
                    'label' => 'Categories',
                    'data' => $trx->pluck('sum')->toArray(),
                    'backgroundColor' => $trx->pluck('category.colour')->toArray(),
                ],
            ],
        ];
    }
    protected function getType(): string
    {
        return 'pie';
    }

}
