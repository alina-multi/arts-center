<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Cache;
use App\Notifications\MailResetPasswordNotification;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory, Billable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'country'
    ];

    public $highlights;

    protected $visible = ['id', 'name', 'username', 'created_at', 'photo', 'avatar'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'country' => $this->country,
            'rating' => (int) $this->rating,
            'created_at' => $this->created_at,
            'photo' => $this->photo->toArray(),
            'bios' => $this->bios->toArray(),
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }

    public function photo()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function avatar()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }

    public function ratings()
    {
        return $this->hasMany(UserRatings::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function works()
    {
        return $this->morphedByMany(Work::class, 'ownable','ownables');
    }

    public function bios()
    {
        return $this->hasMany(UserBio::class);
    }

    public function getHighlightsAttribute()
    {
        return Cache::remember("user.$this->id.highlights", 60*60*5, function () {
            return Work::whereHas('owners', function ($query) {
                $query->where('ownables.user_id', $this->id);
            })->with([
                         'image:id,name,folder,extension',
                         'titles'
                     ])->orderBy('rating', 'desc')->limit(3)->get()->keyBy('id');
        });
    }

    public function feeds()
    {
        return $this->hasMany(Feed::class);
    }

    public function follows()
    {
        return $this->hasMany(Follow::class);
    }

    public function blacklists()
    {
        return $this->hasMany(Blacklist::class);
    }

    public function isAdmin()
    {
        return $this->email === 'stepanorda87@gmail.com';
    }
}
