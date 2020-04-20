<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed title
 * @property mixed content
 */
class Post extends Model
{
    //

    protected $guarded = ['id'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
