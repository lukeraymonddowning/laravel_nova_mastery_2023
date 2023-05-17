<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

class Book extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Book>
     */
    public static $model = \App\Models\Book::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->onlyOnDetail(),

            Image::make('Cover')
                ->required()
                ->help('The front cover of the book')
                ->path('covers'),

            Text::make('Title')
                ->sortable()
                ->required()
                ->filterable(),

            Trix::make('Blurb')
                ->required()
                ->alwaysShow()
                ->fullWidth(),

            Number::make('Pages', 'number_of_pages')
                ->help('The total number of pages in the book')
                ->required()
                ->hideFromIndex(),

            Number::make('Number of Copies')
                ->help('The total copies of this book that the library owns')
                ->required()
                ->default(1)
                ->sortable()
                ->filterable(),

            Boolean::make('Featured', 'is_featured')
                ->help('Whether or not this book should be featured on the homepage')
                ->sortable()
                ->filterable(),

            URL::make('Purchase URL')
                ->help('Our preferred link for purchasing a new copy of this book')
                ->hideFromIndex()
                ->displayUsing(fn () => $this->purchase_url ? parse_url($this->purchase_url)['host'] : null),

            File::make('PDF')
                ->help('Only books in the public domain should have PDF equivalents')
                ->path('pdfs')
                ->acceptedTypes('.pdf'),
        ];
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
