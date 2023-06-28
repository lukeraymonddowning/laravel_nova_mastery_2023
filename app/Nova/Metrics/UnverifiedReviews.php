<?php

namespace App\Nova\Metrics;

use App\Models\Review;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;

class UnverifiedReviews extends Table
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return Review::whereNull('verified_at')
            ->with('reviewer')
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn ($review) => MetricTableRow::make()
                ->title($review->title)
                ->subtitle("By {$review->reviewer->name}")
                ->actions(fn () => [
                    MenuItem::link('View', 'resources/reviews/' . $review->id),
                ])
            );
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
         return now()->addMinutes(5);
    }
}
