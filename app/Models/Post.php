<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = ['user_id','title','sub_title','description','city','country','street','status','slug'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function uploads()
    {
        return $this->morphMany(Upload::class, 'uploadsable');
    }

    public function postImage()
    {
        return $this->morphOne(Upload::class, 'uploadsable')->where('type', 'post_image');
    }

    public function getPostImageUrlAttribute()
    {
        if ($this->postImage) {
            return $this->postImage->file_url;
        }
        return "";
    }
}
