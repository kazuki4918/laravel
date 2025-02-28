<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'content',
        'tel',
        'email',
        'deadline',
        'del_flg',
    ];
}
