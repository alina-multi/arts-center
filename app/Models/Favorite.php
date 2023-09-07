<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['user_id', 'work_id', 'favorite_folder_id'];

    // Because we don't have regular ID
    protected function setKeysForSaveQuery($query)
    {
        return $query
            ->where('user_id', $this->user_id)
            ->where('work_id', $this->work_id)
            ->where('favorite_folder_id', $this->favorite_folder_id);
    }
}
