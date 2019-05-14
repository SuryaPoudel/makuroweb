<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class header extends Model
{
    protected $fillable = [
        'title', 'titleabout', 'siteaddress', 'metakeywords','metadescription'
    ];
}
