<?php

namespace App\Nova;

use App\Enums\WorkStatuses;
use App\Nova\Actions\ClearCacheByTag;
use App\Nova\Actions\PublishWork;
use App\Nova\Actions\TranslateWork;
use App\Nova\Actions\ValidateWork;
use App\Nova\Filters\WorkPublished;
use App\Nova\Filters\WorkStatus;
use App\Nova\Metrics\WorksPerDay;
use App\Models\Product;
use Laravel\Nova\Http\Requests\NovaRequest as Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\MorphMany;
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
    public static $model = \App\Models\Work::class;

    public static $with = ['titles', 'preview', 'preview.variants'];

    public function title()
    {
        if (sizeof($this->titles) > 0) {
            $returnTitle = $this->id;
            foreach ($this->titles as $title) {
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

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        $getTitle = function ($language) {
            if (sizeof($this->titles) > 0) {
                $titleModel = $this->titles->firstWhere('language', $language);
                return $titleModel ? $titleModel->title : '';
            }
        };
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Image::make('preview')->preview(function ($value, $disk) {
                return $value ? $value->src : '';
            })->thumbnail(function ($value, $disk) {
                return $value ? $value->src : '';
            }),
            HasMany::make('WorkTitles', 'titles'),
            Text::make('Titles', function () use ($getTitle) {
                $titles = [];
                foreach (['ru', 'en', 'uk'] as $lang) {
                    $local = $getTitle($lang);
                    if ($local) {
                        $titles[] = "<div><b>$lang</b>: " . $getTitle($lang) . "</div>";
                    }
                }
                return '<div class="divide-y divide-light-blue-400">' . join("\n", $titles) . '</div>';
            })->asHtml()->hideFromDetail(),
            MorphMany::make('Owners', 'owners', User::class),
            Number::make('rating')->sortable(),
            Number::make('comments')->sortable(),
            Number::make('price')->sortable(),
            Text::make('status', fn (\App\Models\Work $work) => $work->status->name),
            DateTime::make('Published', 'published_at')->readonly()->sortable(),
            Text::make('created_at')->hideFromIndex(),
            Text::make('updated_at')->hideFromIndex(),
            Text::make('published_at')->hideFromIndex(),
            HasMany::make('WorkLogs', 'logs'),
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
        return [new WorksPerDay(), new \App\Nova\Metrics\WorkStatus()];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [new WorkStatus()];
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
        return [(new ClearCacheByTag(['work', 'gallery']))->standalone(), new TranslateWork(), new ValidateWork(), new PublishWork()];
    }
}
