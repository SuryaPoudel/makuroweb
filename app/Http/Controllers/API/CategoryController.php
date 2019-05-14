<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;

class CategoryController extends Controller
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
      $CategoryId=Category::select('id')->whereNull('parent')->get();
      foreach ($CategoryId as $id) {
          //$wherekey=$pageId;
          $data[]=Category::select('*')->where('id',$id->id)->orWhere('parent',$id->id)->get();
          //$i++;
      }


                    return json_encode($data);

    }


    public function GetCategoryDistinct()
    {
    $parent = Category::select('catname','id')->get();
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
      $title = Category::where('catname', '=', $request->input('catname'))->first();
      if ($title === null) {


                      try {
                          $this->validate($request,[
                              'catname' => 'required|string|max:191'

                          ]);
                          $create=Category::create([
                              'catname' => $request['catname'],
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
          return  ['status'=>false,'msg'=>'This category is already created.'];
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
      return Category::find($id);
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
        $category=Category::findOrFail($id);
        $input=$request->all();


        $this->validate($request,[
        'catname' => 'required|string|max:191'

        ]);

        if($request->input('parent')=='null')
        {
        $input['parent']=null;

        }

        $category->update($input);

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
      $category = Category::find($id);
        $category->delete();
        return ['status'=>true,'msg'=>'Deleted Sucessfully.'];
    }
}
