<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
$i=0;
$data = [];
$pageId=Page::select('id')->whereNull('parent')->get();
foreach ($pageId as $id) {
    //$wherekey=$pageId;
    $data[]=Page::select('*')->where('id',$id->id)->orWhere('parent',$id->id)->get();
    //$i++;
}


              return json_encode($data);
    }


      public function GetPageDistinct()
      {
          $parent = Page::select('title','id')->get();
        return $parent;


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
        $title = Page::where('title', '=', $request->input('title'))->first();
        if ($title === null) {


                        try {
                            $this->validate($request,[
                                'title' => 'required|string|max:191'

                            ]);
                            $create=Page::create([
                                'title' => $request['title'],
                                'description' => $request['editorData'],
                                'parent' => $request['parent'],
                                'order' => $request['order'],

                            ]);

                        return  ['status'=>true,'msg'=>'Sucessfully done.'];
                } catch (Exception $e) {
                //    report($e);

                    return  ['status'=>false,'msg'=>$e];

                }
        }
        else {
            return  ['status'=>false,'msg'=>'This title is already created.'];
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
return Page::find($id);

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
        try {
            $page=Page::findOrFail($id);
            $input=$request->all();


            $this->validate($request,[
                'title' => 'required|string|max:191'

            ]);
            $input['description']=$request->input('editorData');

            if($request->input('parent')=='null')
            {
                $input['parent']=null;

            }

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
          $page = Page::find($id);
            $page->delete();
            return ['status'=>true,'msg'=>'Deleted Sucessfully.'];

    }
}
