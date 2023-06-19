<?php

namespace App\Nova\Relationships;

use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;

class LoanFields
{
    public function __invoke(NovaRequest $request, $relatedModel)
    {
        return [
            DateTime::make('Due Back At')
                ->displayUsing(fn ($value) => $value->format('d/m/Y'))
                ->rules('required', 'date')
                ->creationRules('after_or_equal:now'),

            DateTime::make('Returned At')
                ->rules('nullable', 'date')
                ->hideFromIndex(),
        ];
    }
}
