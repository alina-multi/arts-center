<?php

namespace App\Models;

use App\Enums\ImageExtentions;
use App\Enums\ImageFolders;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

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

    protected $appends = ['src', 'sources', 'original'];

    protected $visible = ['src',  'sources', 'original'];

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
        if (!$original) {
            return '';
        }

        return [
            "src"=> $this->variantToSrc($original),
            "width" => $original->width,
            "height" => $original->height,
        ];
    }

    public function getOriginalFile(): ?string
    {
        return Storage::get($this->getOriginalPath());
    }

    public function getOriginalPath(): string
    {
        $originalVariant = $this->variants
            ->where('original', true)
            ->first();
        return "{$this->folder->value}/$originalVariant->file";
    }

    public function getSourcesAttribute()
    {
        return $this->variants
            ->sortBy([
                ['width','asc'],
                fn ($a, $b) => $a->extension->value <=> $b->extension->value,
            ])
            ->where('original','!=',true)
            ->values() // Here it's important to reset the keys, or it will be an object instead of an array
            ->groupBy(fn ($a, $b) => $a->extension->value)
            ->map(fn(Collection $variants) => [
                'type' => "image/{$variants->first()->extension->value}",
                'srcset' => $variants->map(fn($variant) => "{$this->variantToSrc($variant)} {$variant->width}w")->join(', '),
            ])->values();
    }

    private function addDomain($path)
    {
        srand($this->id);
        $randIdInRange = rand(0, 100);
        return match (App::environment()) {
            'local' => "https://picsum.photos/id/$randIdInRange/600/600",
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
