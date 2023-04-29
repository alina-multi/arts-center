<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest as Request;
use Laravel\Nova\Filters\Filter;

class WorkPublished extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param Request $request
     * @param  Builder  $query
     * @param  mixed  $value
     * @return Builder
     */
    public function apply(Request $request, $query, $value)
    {
        if ($value === 'draft') {
            return $query->whereNull('published_at');
        } else {
            return $query->where('show_'.$value,1)->whereNotNull('published_at');
        }
    }

    /**
     * Get the filter's available options.
     *
     * @param Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'en'=>'en',
            'ru'=>'ru',
            'uk'=>'uk',
            'Draft'=>'draft'
        ];
    }
}
