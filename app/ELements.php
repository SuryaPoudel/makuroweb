<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ELements extends Model
{
    //
    protected $fillable = [
        'furl', 'turl','gurl','twidth','theight','mwidth','mheight','lwidth','lheight','bwidth','bheight','email','map'
    ];
}
