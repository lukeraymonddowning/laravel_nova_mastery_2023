<?php

namespace App\Nova\Lenses;

use App\Nova\Filters\StockFilter;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Nova;

class BookStock extends Lens
{
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
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        return $request->withOrdering($request->withFilters(
            $query->fromSub(fn ($query) => $query
                ->from('books')
                ->select('id', 'cover', 'title', 'number_of_copies')
                ->addSelect([
                    'copies_on_loan' => fn ($query) => $query->selectRaw('count(*)')
                        ->from('book_customer')
                        ->whereColumn('book_customer.book_id', 'books.id')
                        ->whereNull('book_customer.returned_at'),
                    'copies_in_stock' => fn ($query) => $query->selectRaw('number_of_copies - copies_on_loan'),
                ]),
                'books'
            )
        ));
    }

    /**
     * Get the fields available to the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make('id')
                ->sortable(),

            Image::make('Cover'),

            Text::make('Title')->sortable(),

            Number::make('Number of Copies')->sortable(),
            Number::make('Copies on Loan')->sortable(),
            Number::make('Copies in Stock')->sortable(),
        ];
    }

    /**
     * Get the cards available on the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new StockFilter(),
        ];
    }

    /**
     * Get the actions available on the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return parent::actions($request);
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'book-stock';
    }
}
