<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\header;

class HeaderController extends Controller
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

    public function uploadlogo(Request $request)
    {
        $file=$request->input('image');
        $name = 'logo.png';
        \Image::make($file)->resize(300,83)->save(public_path('logo/').$name);
        return $name;
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
        try {
            //code...
        

        $this->validate($request,[
            'title' => 'required',
            'titleabout' => 'required',
        
            'siteaddress' => 'required',
            'metakeywords' => 'required',
            'metadescription' => 'required',
        ]);
        header::query()->truncate();


        $create=header::create([
            'title' => $request['title'],
            'titleabout' => $request['titleabout'],
            'siteaddress' => $request['siteaddress'],
            'metakeywords' => $request['metakeywords'],
            'metadescription' => $request['metadescription']

        ]);

        return ['msg'=>'Updated sucessfully.'];
    } catch (\Exception $ex) {
        return ['error'=>$ex];
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return header::find($id);
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
