<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_at',
        'name',
        'user_id',
        'old_user_id',
        'work_id',
        'folder',
        'extension'
    ];

    protected $appends = ['url', 'srcset'];

    protected $visible = ['url', 'srcset'];

    public function getPathAttribute()
    {
        return '/' . $this->folder . '/' . $this->name;
    }

    public function getUrlAttribute()
    {
        foreach ([300, 600, 1200, 2400] as $width) {
            if ($this->{"w$width"}) {
                return $this->addDomain($this->path) . "-w$width.jpeg";
            }
        }
        // Original file only as fallback
        return $this->addDomain($this->path) . '.' . $this->extension;
    }

    public function getSrcsetAttribute()
    {
        $src = [];
        foreach ([300, 600, 1200, 2400] as $width) {
            if ($this->{"w$width"}) {
                $src[] = $this->addDomain("$this->path-w$width.webp {$width}w");
                $src[] = $this->addDomain("$this->path-w$width.jpeg {$width}w");
            }
        }
        return join(", ", $src);
    }

    private function addDomain($path)
    {
        if (App::environment('local')) {
            return 'https://arts2.develop/arts' . $path;
        } elseif (App::environment('staging')) {
            return 'https://i.arts2.art' . $path;
        } elseif (App::environment('production')) {
            return 'https://i.arts.center' . $path;
        } elseif (App::environment('testing')) {
            return $path;
        }
    }
}
