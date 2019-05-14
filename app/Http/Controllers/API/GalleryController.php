<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Photogallery;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Photogallery::select('*')
        ->orderBy('created_at', 'desc')
        ->paginate(20);


        return $posts;
    }


public function SearchGallery()
{
    $searchkey = \Request::get('q');

    $posts =  Photogallery::select('*')
    ->where('caption','LIKE',"%$searchkey%")
    ->orWhere('album','LIKE',"%$searchkey%")
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

public function selectAlbum()
{   $album = Photogallery::select('album')
    ->groupBy('album')
    ->whereNotNull('album')
    ->get();
    return $album;
}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];
        $i=0;
        foreach($request->input('results') as $message){

           // $data[$i] = [$message['image']];
       
            $i++;
       
            $file=$message['image'];
            $name = $i.time().'.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];

         \Image::make($file)->save(public_path('photogallery/').$name);
         $create=Photogallery::create([
            'album' => $request->input('album'),
            'caption' =>$message['caption'],
            'image' => $name,

        ]);

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
        return Photogallery::find($id);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //return Photogallery::find($id);
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



        $Gallery=Photogallery::findOrFail($id);
        $input=$request->all();


        if (!empty($request->input('image')))
        {
            $name = time().'.' . explode('/', explode(':', substr($request->input('image'), 0, strpos($request->input('image'), ';')))[1])[1];

            \Image::make($request->input('image'))->save(public_path('photogallery/').$name);

            $input['image']=$name;
            \DB::table('photogalleries')
            ->where('id',$id)
            ->update([
                'album'=>$request->input('album'),
               'caption' => $request->input('caption'),
               'image'=>$name
               
           ]);
    
            }
            else
            {
                \DB::table('photogalleries')
                ->where('id',$id)
                ->update([
                    'album'=>$request->input('album'),
                   'caption' => $request->input('caption'),
                   
               ]);
    
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
        $category = Photogallery::find($id);
        $category->delete();
        return ['status'=>true,'msg'=>'Deleted Sucessfully.'];
    }
}
