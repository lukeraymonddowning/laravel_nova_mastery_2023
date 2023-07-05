<?php

namespace App\Nova;

use App\Nova\Actions\DestroyUnverifiedReviews;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Query\Search\SearchableMorphToRelation;
use Laravel\Nova\Query\Search\SearchableText;
use Readit\StarRating\StarRating;

class Review extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Review>
     */
    public static $model = \App\Models\Review::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    public static $with = ['reviewable'];

    public static $globalSearchResults = 10;

    public function subtitle()
    {
        return match ($this->reviewable::class) {
            \App\Models\Author::class => $this->reviewable->name,
            \App\Models\Book::class => $this->reviewable->title,
            default => null,
        };
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()
                ->sortable(),

            MorphTo::make('Reviewer')
                ->types([
                    User::class,
                    Customer::class,
                ]),

            MorphTo::make('Reviewable')
                ->types([
                    Author::class,
                    Book::class,
                ]),

            Text::make('Title')
                ->rules('required', 'string', 'max:255'),

            Trix::make('Body')
                ->rules('required', 'string', 'max:65535'),

            StarRating::make('Stars')
                ->rules('nullable', 'integer', 'min:1'),

            DateTime::make('Verified At')
                ->nullable()
                ->hideFromIndex()
                ->rules('nullable', 'date'),

            Boolean::make('Verified', fn() => $this->verified_at !== null)
                ->filterable()
                ->exceptOnForms(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            Action::using('Verify', function (ActionFields $fields, Collection $models) {
                \App\Models\Review::whereKey($models->pluck('id'))
                    ->whereNull('verified_at')
                    ->update([
                        'verified_at' => now(),
                    ]);
            }),
            (new DestroyUnverifiedReviews())->standalone()->confirmText('Are you sure you want to run this action? This action cannot be undone.'),
        ];
    }
}
