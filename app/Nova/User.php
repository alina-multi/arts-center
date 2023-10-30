<?php

namespace App\Nova;

use App\Nova\Actions\ApproveRecord;
use App\Nova\Actions\ClearCacheByTag;
use App\Nova\Actions\SendBlogPost;
use App\Nova\Actions\VerifyUser;
use App\Nova\Filters\ModelApproved;
use App\Nova\Filters\UserCountry;
use App\Nova\Filters\UserNotCountry;
use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\UsersPerDay;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest as Request;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasManyThrough;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\MorphedByMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static $with = ['photo', 'photo.variants'];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email', 'username'
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
            ID::make()->sortable(),

            Image::make('photo')->preview(function ($value, $disk) {
                return $value ? $value->src : '';
            })->thumbnail(function ($value, $disk) {
                return $value ? $value->src : '';
            }),


            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            URL::make('Username', fn() => config('app.frontend_url')."/$this->username")
                ->displayUsing(fn() => $this->username)
                ->sortable()
                ->rules('required', 'max:255')
            ,

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Text::make('Country'),

            Boolean::make('Approved', 'approved_at'),
            Boolean::make('Verified', 'verified_at'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),
            HasMany::make('Transactions'),
            MorphedByMany::make('Works'),
            HasMany::make('User Ratings', 'ratings'),
            HasMany::make('Comments'),
            HasMany::make('Feeds'),
            HasMany::make('Follows'),
            HasMany::make('Blacklists')
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
        return [new UsersPerDay()];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new ModelApproved(),
            new UserNotCountry(),
            new UserCountry()
        ];
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
            (new ClearCacheByTag('user'))->standalone(),
            new ApproveRecord(),
            new VerifyUser(),
            new SendBlogPost()
        ];
    }
}
