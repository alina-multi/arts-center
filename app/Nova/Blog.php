<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasManyThrough;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Number;

class Blog extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Blog::class;

    public function title()
    {
        if (sizeof($this->translations) > 0) {
            $returnTitle = $this->id;
            foreach ($this->translations as $title) {
                $returnTitle .= " $title->language: $title->title";
            }
            return $returnTitle;
        } else {
            return $this->id;
        }
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $with = ['translations'];

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
            Text::make('Titles', function () {
                $titles = [];
                foreach ($this->translations as $translation) {
                    $titles[] = "<div><b>$translation->language</b>: $translation->title </div>";
                }
                return '<div class="divide-y divide-light-blue-400">' . join("\n", $titles) . '</div>';
            })->asHtml(),
            Boolean::make('Featured'),
            Number::make('Rating'),
            DateTime::make('created_at'),
            DateTime::make('updated_at'),
            DateTime::make('deleted_at'),
            HasMany::make('Translations', 'translations', BlogTranslation::class),
            HasMany::make('Posts'),
            MorphMany::make('Owners', 'owners', User::class),
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
        return [];
    }
}
