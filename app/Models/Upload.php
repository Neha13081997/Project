<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [
        'name',
        'uploadsable',
        'file_path',
        'title',
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

}
