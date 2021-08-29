<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Work extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Work::class;

    public static $with = ['titles', 'image'];

    public function title()
    {
        if (sizeof($this->titles)>0) {
            $returnTitle = $this->id;
            foreach ($this->titles as $title) {
                $returnTitle.=" $title->language: $title->title";
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

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $getTitle = function($language) {
            if (sizeof($this->titles) > 0) {
               $titleModel = $this->titles->firstWhere('language', $language);
               return $titleModel ? $titleModel->title : '';
            }
        };
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Image::make('image')->preview(function ($value, $disk) {
                return $value ? $value->url : '';
            })->thumbnail(function ($value, $disk) {
                return $value ? $value->url : '';
            }),
            HasMany::make('WorkTitles','titles'),
            Text::make('en', function () use ($getTitle) {
                return $getTitle('en');
            }),
            Text::make('ru', function () use ($getTitle) {
                return $getTitle('ru');
            }),
            Text::make('uk', function () use ($getTitle) {
                return $getTitle('uk');
            }),
            Number::make('rating')->sortable(),
            Number::make('comments')->sortable(),
            Number::make('price')->sortable(),
        ];
    }



    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
