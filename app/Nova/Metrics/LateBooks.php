<?php

namespace App\Nova\Metrics;

use App\Models\Loan;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Nova;

class LateBooks extends Trend
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this
            ->countByDays($request, Loan::whereColumn('returned_at', '>', 'due_back_at'), 'due_back_at')
            ->showSumValue();
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            10 => Nova::__('10 Days'),
            30 => Nova::__('30 Days'),
            60 => Nova::__('60 Days'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'late-books';
    }
}
