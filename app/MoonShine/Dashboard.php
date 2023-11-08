<?php

namespace App\MoonShine;
 
use App\Models\User;
use MoonShine\Dashboard\DashboardBlock;
use MoonShine\Dashboard\DashboardScreen;
use MoonShine\Metrics\ValueMetric;
 
class Dashboard extends DashboardScreen
{
    public function blocks(): array
    {
        return [
            DashboardBlock::make([
                ValueMetric::make('Users')
                    ->value(User::query()->count())
            ]),
        ];
    }
}
