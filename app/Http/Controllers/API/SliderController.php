<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Slider;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Slider::select('*')
        ->orderBy('created_at', 'desc')
        ->paginate(20);


        return $posts;
    }


public function SearchSlider()
{
    $searchkey = \Request::get('q');

    $posts =  Slider::select('*')
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

public function selectSlidertype()
{   $album = Slider::select('album')
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

         \Image::make($file)->save(public_path('slider/').$name);
         $create=Slider::create([
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
        return Slider::find($id);
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
        //return Slider::find($id);
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



        $Gallery=Slider::findOrFail($id);
        $input=$request->all();


        if (!empty($request->input('image')))
        {
            $name = time().'.' . explode('/', explode(':', substr($request->input('image'), 0, strpos($request->input('image'), ';')))[1])[1];

            \Image::make($request->input('image'))->save(public_path('slider/').$name);

            $input['image']=$name;

            
        \DB::table('sliders')
        ->where('id',$id)
        ->update([
            'album'=>$request->input('album'),
           'caption' => $request->input('caption'),
           'image'=>$name
           
       ]);

        }
        else
        {
            \DB::table('sliders')
            ->where('id',$id)
            ->update([
                'album'=>$request->input('album'),
               'caption' => $request->input('caption'),
               
           ]);

        }





        // $input['caption']=$request->input('caption');
        // $input['album']=$request->input('album');

        //  $Gallery->update($input);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Slider::find($id);
        $category->delete();
        return ['status'=>true,'msg'=>'Deleted Sucessfully.'];
    }
}
