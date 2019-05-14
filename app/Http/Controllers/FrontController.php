<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use APP\page;


class FrontController extends Controller
{
    //
    
    public function getpage_dynamically()
    {
        return view('layouts.frontend-pages.page');
    }


    public function SelectParentMenu()
    {
        $Pages=Page::select('id,title')->whereNull('parent')->get();
        return $Pages;

    }
}
