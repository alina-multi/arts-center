<?php

namespace App\Nova\Lenses;

use App\Enums\WorkStatuses;
use App\Models\Work;
use App\Nova\Actions\ApproveRecord;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;

class ArtistPendingApproval extends Lens
{
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [];

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
            $query->select(self::columns())
                ->join('ownables', 'users.id', '=', 'ownables.user_id')
                ->join('works', 'ownables.ownable_id', '=', 'works.id')
                ->where('ownable_type', 'work')
                ->where('works.status', WorkStatuses::READY)
                ->whereNull('users.approved_at')
                ->groupBy('users.id')
                ->limit(10)
        ), fn ($query) => $query->orderBy('users.created_at', 'desc'));
    }
    protected static function columns()
    {
        return [
            'users.id',
            'users.name',
            'users.username',
            'users.created_at',
            'users.last_seen',
            'users.image_id',
            DB::raw('GROUP_CONCAT(works.id) as ready_works')
        ];
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
            ID::make('ID'),
            Image::make('Photo', 'image_id')->preview(function ($value, $disk) {
                return $value ? \App\Models\Image::whereId($value)->first()?->src: null;
            })->thumbnail(function ($value, $disk) {
                return $value ? \App\Models\Image::whereId($value)->first()?->src: null;
            }),
            Text::make('Name'),
            URL::make('Username', fn() => config('app.frontend_url')."/$this->username")
                ->displayUsing(fn() => $this->username)
                ->sortable()
                ->rules('required', 'max:255')
            ,
            Text::make('Ready Works', function () {
                return view('nova::partials.gallery',[
                    'works' => Work::whereIn('id', explode(',', $this->ready_works))->with('preview')->get(),
                ])->render();
            })->asHtml(),
            DateTime::make('Created At'),
            DateTime::make('Last Seen')->onlyOnIndex(),
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
        return [];
    }

    /**
     * Get the actions available on the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [new ApproveRecord(),];
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'artists-avaiting-approval';
    }
}
