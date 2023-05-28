<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File as FileRule;
use Laravel\Nova\Fields\BelongsTo;
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
        'author.name',
        'genre.name',
        'subgenre.name',
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
            ID::make()->sortable(),

            Image::make('Cover')
                ->required()
                ->help('The front cover of the book')
                ->path('covers')
                ->rules(FileRule::image()->max(4 * 1024))
                ->creationRules('required'),

            Text::make('Title')
                ->sortable()
                ->filterable()
                ->rules('required', 'string', 'max:255'),

            BelongsTo::make('Genre')
                ->relatableQueryUsing(fn ($request, $query) => $query->whereNull('parent_id'))
                ->rules('required', Rule::exists('genres', 'id')->whereNull('parent_id')),

            BelongsTo::make('Subgenre', resource: Genre::class)
                ->hideFromIndex()
                ->nullable()
                ->dependsOn('genre', function ($subgenre, $request, $data) {
                    $data['genre'] === null
                        ? $subgenre->hide()
                        : $subgenre->relatableQueryUsing(fn ($request, $query) => $query->where('parent_id', $data['genre']));
                })
                ->rules(fn ($request) => ['nullable', Rule::exists('genres', 'id')->where('parent_id', $request->genre)]),

            BelongsTo::make('Author')
                ->searchable()
                ->showCreateRelationButton()
                ->modalSize('3xl')
                ->rules('required', 'exists:authors,id'),

            BelongsTo::make('Publisher')
                ->showCreateRelationButton()
                ->modalSize('3xl')
                ->hideFromIndex()
                ->filterable()
                ->rules('required', 'exists:publishers,id'),

            Trix::make('Blurb')
                ->required()
                ->alwaysShow()
                ->fullWidth()
                ->rules('required', 'string', 'max:2000'),

            Number::make('Pages', 'number_of_pages')
                ->help('The total number of pages in the book')
                ->required()
                ->hideFromIndex()
                ->rules('required', 'int', 'min:1'),

            Number::make('Copies', 'number_of_copies')
                ->help('The total copies of this book that the library owns')
                ->required()
                ->default(1)
                ->sortable()
                ->filterable()
                ->rules('required', 'int', 'min:1'),

            Boolean::make('Featured', 'is_featured')
                ->help('Whether or not this book should be featured on the homepage')
                ->sortable()
                ->filterable()
                ->rules('boolean'),

            URL::make('Purchase URL')
                ->help('Our preferred link for purchasing a new copy of this book')
                ->hideFromIndex()
                ->displayUsing(fn () => $this->purchase_url ? parse_url($this->purchase_url)['host'] : null)
                ->rules('nullable', 'url'),

            File::make('PDF')
                ->help('Only books in the public domain should have PDF equivalents')
                ->path('pdfs')
                ->acceptedTypes('.pdf')
                ->rules('nullable', FileRule::types('pdf')->max(12 * 1024))
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
