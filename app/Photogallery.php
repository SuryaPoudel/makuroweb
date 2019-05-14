<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photogallery extends Model
{
    //
    protected $fillable = [
        'album', 'caption', 'image'
    ];
}
