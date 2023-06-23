<?php

namespace App\Nova\Filters;

use Illuminate\Support\Carbon;
use Laravel\Nova\Filters\DateFilter;
use Laravel\Nova\Http\Requests\NovaRequest;

class LoanTimeframeFilter extends DateFilter
{
    public function __construct(private string $operator)
    {
    }

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        $value = Carbon::parse($value);

        return $query->whereHas('allLoans', fn ($query) => $query->where('book_customer.created_at', $this->operator, $value));
    }

    public function name()
    {
        return match($this->operator) {
            '<=' => 'Loans before',
            '>=' => 'Loans after',
            default => 'Loans on',
        };
    }

    public function key()
    {
        return "loan-filter-{$this->name()}";
    }
}
