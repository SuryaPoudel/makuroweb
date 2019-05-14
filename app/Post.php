<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
     protected $fillable = [
          'cid', 'title', 'details', 'tag','img','count'
      ];

}
