<?php

namespace Readit\PopularBooksBarChart;

use Laravel\Nova\Card;

class PopularBooksBarChart extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = self::ONE_HALF_WIDTH;

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'popular-books-bar-chart';
    }
}
