<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\LateBooks;
use App\Nova\Metrics\UnverifiedReviews;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new LateBooks(),
            (new UnverifiedReviews())->width('full'),
        ];
    }
}
