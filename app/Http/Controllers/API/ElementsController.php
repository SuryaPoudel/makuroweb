<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ELements;

class ElementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        
        Elements::query()->truncate();


        $create=Elements::create([
            'furl'=> $request['furl'],
            'turl'=>  $request['turl'],
            'gurl'=> $request['gurl'],
            'twidth'=> $request['twidth'],
            'theight'=> $request['theight'],
            'mwidth'=> $request['mwidth'],
            'mheight'=> $request['mheight'],
            'lwidth'=> $request['lwidth'],
            'lheight'=> $request['lheight'],
            'bwidth'=> $request['bwidth'],
            'bheight'=> $request['bheight'],
            'email'=> $request['email'],
            'map'=> $request['map']
        ]);

        return ['msg'=>'Updated sucessfully.'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return Elements::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
