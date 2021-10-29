<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'created_at',
        'username',
        'old_id',
        'country'
    ];

    public $highlights;

    protected $visible = ['id', 'name', 'username', 'created_at', 'photo'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new Notifications\MailResetPasswordNotification($token));
    }

    public function photo()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable');
    }

    public function ratings()
    {
        return $this->hasMany('App\UserRatings', 'user_id');
    }

    public function getHighlightsAttribute()
    {
        return Work::whereHas('owners', function ($query) {
            $query->where('ownables.user_id', $this->id);
        })->with([
                                                           'image:id,name,folder',
                                                           'titles'
                                                       ])->orderBy('rating', 'desc')->limit(3)->get()->keyBy('id');
    }
}
