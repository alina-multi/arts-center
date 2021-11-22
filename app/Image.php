<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'created_at', 'name', 'user_id', 'old_user_id', 'work_id', 'folder'
    ];

    protected $appends = ['url'];

    protected $visible = ['url'];

    public function getUrlAttribute()
    {
        if (App::environment('local')) {
            return 'http://arts2.develop/arts/' . $this->folder . '/' . $this->name;
        } else if (App::environment('staging')) {
            return 'https://i.arts2.art/' . $this->folder . '/' . $this->name;
        } else if (App::environment('production')) {
            return 'https://i.arts.center/' . $this->folder . '/' . $this->name;
        } else if (App::environment('testing')) {
            return $this->folder . '/'. $this->name;
        }
    }
}
