<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'img_01',
        'img_02',
        'img_03',
        'descricao',
        'hash_id',
        'user_id'
    ];
}
