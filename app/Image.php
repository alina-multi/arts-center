<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Image extends Model
{
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
            return 'https://arts2.fra1.cdn.digitaloceanspaces.com/' . $this->folder . '/' . $this->name;
        } else if (App::environment('testing')) {
            return $this->folder . '/'. $this->name;
        }
    }
}
