<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControlPanelRole extends Model
{
    //
    protected $fillable = [
        'name', 'email', 'password','permission'
    ];

}
