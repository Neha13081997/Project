<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
    protected $fillable = [
        // 'name',
        'uploadsable',
        'file_path',
        // 'title',
        'original_file_name',
        'type',
        'file_type',
        'extension',
        'orientation',
        'created_at',
        'updated_at',
    ];

    public function uploadsable()
    {
        return $this->morphTo();
    }

    // to get the image url.
    public function getFileUrlAttribute()
    {
        $media = "";
        if(Storage::disk('public')->exists($this->file_path)){
            $media = asset('storage/'.$this->file_path);
        }
        return $media;
    }
}
