<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BottomFooter;
class BottomFooterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = BottomFooter::select('*')
        ->orderBy('created_at', 'desc')
        ->get();


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


    
                            $this->validate($request,[
                                'heading' => 'required|string|max:191',
                                'content' => 'required'

                            ]);
        
        $create=BottomFooter::create([
            'heading' => $request['heading'],
            'content' =>  $request['content']
        ]);

        return ['msg'=>'Done sucessfully.'];
     
     
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
        return BottomFooter::find($id);
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
        $TopFooter=BottomFooter::findOrFail($id);
        $input=$request->all();
        $this->validate($request,[
            'heading' => 'required|string|max:191',
            'content' => 'required'

        ]);

$input['heading']=$request->input('heading');
$input['content']=$request->input('content');

 $TopFooter->update($input);

return ['msg'=>'Done sucessfully.'];

        
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
        $topfooter = BottomFooter::find($id);
        $topfooter->delete();
        return ['msg'=>'Deleted Sucessfully.'];
    }
}
