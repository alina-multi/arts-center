<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class ModelApproved extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    public $name = 'Approved';

    /**
     * Apply the filter to the given query.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query
            ->when($value === 'approved', fn(Builder $q) => $q->whereNotNull('approved_at'))
            ->when($value === 'not', fn(Builder $q) => $q->whereNull('approved_at'));
    }

    /**
     * Get the filter's available options.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return [
            "Approved" => 'approved',
            "Not approved" => 'not'
        ];
    }
}
