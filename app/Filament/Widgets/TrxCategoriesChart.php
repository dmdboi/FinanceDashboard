<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

class TrxCategoriesChart extends ChartWidget
{
    protected static ?string $heading = 'By Category';

    protected function getData(): array
    {

        // Fetch the total transactions for each category in the last 30 days
        $trx = Transaction::query()
            ->select([
                'category_id',
                DB::raw('COUNT(*) as total')
            ])
            ->where('trx_date', '>=', now()->subDays(30))
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->get();

        return [
            //
            'labels' => $trx->pluck('category.name')->toArray(),
            'datasets' => [
                [
                    'label' => 'Categories',
                    'data' => $trx->pluck('total')->toArray(),
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
