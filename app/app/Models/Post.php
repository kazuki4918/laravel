<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'amount',
        'del_flg',
    ];

    public function violations()
    {
        return $this->hasMany(Violation::class, 'post_id');
    }
}
