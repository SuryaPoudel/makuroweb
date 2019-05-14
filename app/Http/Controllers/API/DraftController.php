<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Draft;

class DraftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Drafts = Draft::select('*')
        ->orderBy('id', 'desc')
        ->paginate(10);


        return $Drafts;
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
      

        try {
          
            $this->validate($request,[
                'title' => 'required|string|max:300',
                'editorData' => 'required|min:100',
            ]);

            $create=Draft::create([
                 'title' => $request['title'],
                 'description' => $request['editorData'],

             ]);

          }
   catch (Exception $e) {
    return  ['status'=>false,'msg'=>$e];

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
        //
        return Draft::find($id);
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
        try {
            $page=Draft::findOrFail($id);
            $input=$request->all();

            $this->validate($request,[
                'title' => 'required|string|max:300',
                'editorData' => 'required|min:100',
            ]);
      

            $input['description']=$request->input('editorData');
             $page->update($input);

    } catch (Exception $e) {
        return  ['status'=>false,'msg'=>$e];
    }

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
        $draft = Draft::find($id);
        $draft->delete();
        return ['status'=>true,'msg'=>'Deleted Sucessfully.'];
    }
}
