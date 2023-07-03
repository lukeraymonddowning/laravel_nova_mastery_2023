<?php

namespace Readit\StarRating;

use Laravel\Nova\Fields\Field;

class StarRating extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'star-rating';

    public function maxStars(int $max)
    {
        return $this->withMeta(['maxStars' => $max]);
    }
}
