<?php

namespace App\Nova;

use App\Nova\Actions\ApproveRecord;
use Ek0519\Quilljs\Quilljs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;


class Feedback extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Feedback::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'type',
        'category'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make('user'),
            Text::make('title')->required(),
            Select::make('type')->options(array_combine(array_keys(\App\Feedback::TYPE_CATEGORY), array_keys(\App\Feedback::TYPE_CATEGORY)))->required(),
            Select::make('category')->options(array_combine(\App\Feedback::TYPE_CATEGORY['complaint'], \App\Feedback::TYPE_CATEGORY['complaint'])),
            Code::make('body')->json()->required(),
            Select::make('language')->options(config('app.languages'))->required(),
            Hidden::make('user_id')->default(Auth::id()),
            DateTime::make('created_at'),
            DateTime::make('updated_at'),
            DateTime::make('approved_at'),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new ApproveRecord)->showOnTableRow()->canSee(function () {
                return !$this->resource->approved_at;
            }),
        ];
    }
}
