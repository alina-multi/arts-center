<?php

namespace App\Models;

use App\Enums\TagTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['type_id', 'old_id'];
    public $timestamps = false;
    protected $casts = [
        'type_id' => TagTypes::class
    ];
    public function titles()
    {
        return $this->hasMany(TagTitle::class);
    }
}
