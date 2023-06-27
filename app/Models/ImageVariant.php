<?php

namespace App\Models;

use App\Enums\ImageExtentions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageVariant extends Model
{
    use HasFactory;

    protected $appends = ['file'];
    protected $fillable = ['image_id', 'extension', 'width', 'height', 'size', 'original'];
    protected $casts = [
        'original' => 'boolean',
        'extension' => ImageExtentions::class
    ];

    function getFileAttribute(): string
    {
        return "$this->id.{$this->extension->value}";
    }
}
