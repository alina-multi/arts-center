<?php

namespace App\Nova\Filters;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class UserNotCountry extends Filter
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
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->whereNot('country', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return DB::table('users')
            ->selectRaw('country, COUNT(id) as count')
            ->groupBy('country')
            ->whereNotNull('country')
            ->orderBy('count', 'desc')
            ->get()
            ->mapWithKeys(fn($row)=>["$row->country ($row->count)"=>$row->country]);
    }
}
