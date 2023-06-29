<?php

namespace App\Models;

use App\Enums\ImageExtentions;
use App\Enums\ImageFolders;
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
        'extension',
    ];
    protected $casts = [
        'folder' => ImageFolders::class
    ];

    protected $appends = ['src', 'srcset', 'sources'];

    protected $visible = ['src', 'srcset', 'sources'];

    public function variants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ImageVariant::class);
    }

    public function getPathAttribute()
    {
        return '/' . $this->folder->value . '/' . $this->name;
    }

    public function getSrcAttribute()
    {
        $smallestJpeg = $this->variants
            ->sortBy('width')
            ->where('extension', '!=', ImageExtentions::webp)
            ->first();
        return $smallestJpeg ? $this->variantToSrc($smallestJpeg) : '';
    }

    public function getOriginalAttribute()
    {
        $original = $this->variants
            ->where('original', true)
            ->first();
        return $original ? $this->variantToSrc($original) : '';
    }

    public function getSrcsetAttribute()
    {
        return $this->variants
            ->where('original', false)
            ->where('extension', '!=', ImageExtentions::webp)
            ->sortBy('width')
            ->map(fn($variant) => "{$this->variantToSrc($variant)} {$variant->width}w")->join(', ');
    }

    public function getSourcesAttribute()
    {
        return $this->variants
            ->sortBy([
                ['width','asc'],
                fn ($a, $b) => $a->extension->value <=> $b->extension->value,
            ])
            ->values() // Here it's important to reset the keys, or it will be an object instead of an array
            ->map(fn($variant) => [
                'src' => $this->variantToSrc($variant),
                'width' => $variant->width,
                'height' => $variant->height,
            ]);
    }

    private function addDomain($path)
    {
        return match (App::environment()) {
            'local' => "https://picsum.photos/id/{$this->id}/600/600",
            'staging' => "https://i.arts2.art/$path",
            'production' => "https://i.arts.center/$path",
            default => $path
        };
    }

    private function variantToSrc(ImageVariant $variant): string
    {
        if (!$variant) {
            return '';
        }
        return $this->addDomain("{$this->folder->value}/$variant->file");
    }
}
