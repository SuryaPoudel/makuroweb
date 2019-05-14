<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = Post::select('posts.id','cid','categories.catname', 'title', 'tag','posts.created_at')
            ->join("categories",'posts.cid','=','categories.id')
            ->orderBy('posts.created_at', 'desc')
            ->paginate(20);


            return $posts;
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
                  try {

                    

                      if (!empty($request->file))
                      {
                      $this->validate($request,[
                          'title' => 'required|string|max:191',
                          'file' => 'required|image64:jpeg,jpg,png',
                          'height' => 'required|numeric|min:50|max:800',
                          'width' => 'required|numeric|min:50|max:1000'

                      ]);
                      }
                      else {
                          $this->validate($request,[
                              'title' => 'required|string|max:191'
                            ]);
                      }

                        if($request->file)
                        {

                
                            $file=$request->file;
                          $name = time().'.' . explode('/', explode(':', substr($request->file, 0, strpos($request->file, ';')))[1])[1];


                       \Image::make($request->file)->resize($request->width,$request->height)->save(public_path('featuredimage/').$name);


                        }
                        else {
                            $name=null;
                        }
                      $create=Post::create([
                           'title' => $request['title'],
                           'details' => $request['editorData'],
                           'cid' => $request['parent'],
                           'tag' => $request['tag'],
                           'img' => $name,
                           'count' => 0,

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
      return Post::find($id);
        //
    }


public function uploadfile(Request $request)
{
    $file=$request->upload;
    $name = time().'.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
      \Image::make($file)->save(public_path('featuredimage/').$name);
    
    return ['Status'=>'Image Uploaded','url'=>'featuredimage/'.$name]; 
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

    public function SearchPosts()
    {


        $searchkey = \Request::get('q');

        $posts = Post::select('posts.id','cid','categories.catname', 'title', 'tag','posts.created_at')
        ->join("categories",'posts.cid','=','categories.id')
        ->where('posts.title','LIKE',"%$searchkey%")
        ->orWhere('posts.tag','LIKE',"%$searchkey%")
        ->orderBy('posts.created_at', 'desc')
       ->paginate(20);


        return $posts;


                // if ($search = \Request::get('q')) {
                //     $posts = Post::where(function($query) use ($search){
                //         $query->where('title','LIKE',"%$search%")
                //                 ->orWhere('tag','LIKE',"%$search%");
                //     })->limit(10);
                // }else{
                //     $posts = Post::latest()->paginate(5);
                // }

                // return $posts;

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
                      $page=Post::findOrFail($id);
                      $input=$request->all();


                    
                      if (!empty($request->file))
                      {
                      $this->validate($request,[
                          'title' => 'required|string|max:191',
                          //'image64' => 'The :attribute must be a file of type: :values.',
                          'file' => 'required|image64:jpeg,jpg,png'

                      ]);
                      }
                      else {
                          $this->validate($request,[
                              'title' => 'required|string|max:191'
                            ]);
                      }


                      if($request->file)
                      {
                          $file=$request->file;
                        $name = time().'.' . explode('/', explode(':', substr($request->file, 0, strpos($request->file, ';')))[1])[1];


                      \Image::make($request->file)->resize(650, 500)->save(public_path('featuredimage/').$name);

                      $input['img']=$name;
                      }





                      $input['cid']=$request->input('parent');
                      $input['details']=$request->input('editorData');
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
        $post = Post::find($id);
  $post->delete();
  return ['status'=>true,'msg'=>'Deleted Sucessfully.'];
    }
}
