<?php

namespace App\Nova;

use App\Nova\Lenses\BookStock;
use App\Nova\Relationships\LoanFields;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\MorphMany;
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
        'blurb',
        'author.name',
    ];

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

            Image::make('Cover')
                ->path('covers'),

            Text::make('Title')
                ->sortable()
                ->rules('required', 'string', 'min:1', 'max:255')
                ->creationRules('unique:books,title')
                ->updateRules('unique:books,title,{{resourceId}}'),

            BelongsTo::make('Author')
                ->showCreateRelationButton()
                ->modalSize('3xl')
                ->searchable()
                ->withSubtitles()
                ->sortable(),

            BelongsTo::make('Publisher')
                ->showCreateRelationButton()
                ->modalSize('3xl')
                ->searchable()
                ->filterable()
                ->hideFromIndex(),

            Trix::make('Blurb')
                ->alwaysShow()
                ->fullWidth(),

            Number::make('Pages', 'number_of_pages')
                ->filterable()
                ->hideFromIndex()
                ->rules('required', 'integer', 'min:1', 'max:10000'),

            Number::make('Copies', 'number_of_copies')
                ->sortable()
                ->required()
                ->help('The total number of copies of this book that the library owns.'),

            Boolean::make('Featured', 'is_featured')
                ->help('Whether this book is featured on the homepage.')
                ->filterable(),

            File::make('PDF')
                ->path('pdfs'),

            URL::make('Purchase URL')
                ->displayUsing(fn($value) => $value ? parse_url($value, PHP_URL_HOST) : null)
                ->hideFromIndex(),

            BelongsTo::make('Genre')
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->whereNull('parent_id');
                })
                ->rules('required', Rule::exists('genres', 'id')->whereNull('parent_id')),

            BelongsTo::make('Subgenre', resource: Genre::class)
                ->dependsOn(['genre'], function (BelongsTo $field, NovaRequest $request, FormData $data) {
                    if ($data->genre === null) {
                        $field->hide();
                    }

                    $field
                        ->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($data) {
                            $query->where('parent_id', $data->genre);
                        })
                        ->rules('required', Rule::exists('genres', 'id')->where('parent_id', $data->genre));
                }),

            HasMany::make('Audio Recordings', 'recordings', resource: Recording::class),

            BelongsToMany::make('Current Loans', resource: Customer::class)
                ->fields(new LoanFields()),

            MorphMany::make('Reviews'),
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
        return [
            new BookStock(),
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
