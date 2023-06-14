<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Genre extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Genre>
     */
    public static $model = \App\Models\Genre::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'parent.name'
    ];

    public static $with = ['parent'];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()
                ->sortable(),

            Text::make('Name')
                ->rules('required', 'string', 'max:60'),

            BelongsTo::make('Parent', resource: Genre::class)
                ->help('If this genre is a sub-genre, select the parent genre.')
                ->nullable(),

            HasMany::make('Books'),

            HasMany::make('Sub-Genres', 'subGenres', Genre::class),
        ];
    }

    public function fieldsForIndex(): array
    {
        return [
            ID::make()
                ->sortable(),

            Text::make('Name', function () {
                if ($this->resource->parent) {
                    return "{$this->name}/{$this->resource->parent->name}";
                }

                return $this->name;
            }),
        ];
    }

    public function subtitle()
    {
        return $this->parent?->name ?? '-';
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
