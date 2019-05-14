<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Footer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class FooterController extends Controller
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



    public function uploadlogo(Request $request)
    {
        $file=$request->input('image');
        $name = 'footerlogo.png';
        \Image::make($file)->resize(300,83)->save(public_path('logo/').$name);
        return $name;
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




            // $rules = [
            //     'developerurl' => 'required',
            //     'designby' => 'required|email'
                
            // ];
        
            // $customMessages = [
            //     'required' => 'The :attribute field is required.'
            // ];
        
            // $this->validate($request, $rules, $customMessages);


            // $regex = '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:.\d{1,3}){3})(?!(?:169.254|192.168)(?:.\d{1,3}){2})(?!172.(?:1[6-9]|2\d|3[0-1])(?:.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]-)[a-z\x{00a1}-\x{ffff}0-9]+)(?:.(?:[a-z\x{00a1}-\x{ffff}0-9]-)[a-z\x{00a1}-\x{ffff}0-9]+)(?:.(?:[a-z\x{00a1}-\x{ffff}]{2,})).?)(?::\d{2,5})?(?:[/?#]\S)?$_iuS';

            // $rules = array('developerurl' => array('required', 'regex:'.$regex));
    
            // $customMessages = [
            //     'required' => 'enter the url you want to hew',
            //     'regex' => 'your url have to be a valid url' . "<br/>" . "<span class='val_error_small'>". '(try putting http:// or https:// or another prefix at the beginning)'. "</span>",
            // ];
            // $this->validate($request, $rules, $customMessages);


    //         //code...
        

    //         //$regex = '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:.\d{1,3}){3})(?!(?:169.254|192.168)(?:.\d{1,3}){2})(?!172.(?:1[6-9]|2\d|3[0-1])(?:.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]-)[a-z\x{00a1}-\x{ffff}0-9]+)(?:.(?:[a-z\x{00a1}-\x{ffff}0-9]-)[a-z\x{00a1}-\x{ffff}0-9]+)(?:.(?:[a-z\x{00a1}-\x{ffff}]{2,})).?)(?::\d{2,5})?(?:[/?#]\S)?$_iuS';

    //   //      $rules = array('hewit' => array('required', 'regex:'.$regex));
    // //
    //         $messages = [
    //             'hewit.required' => 'enter the url you want to hew',
    //             'hewit.regex' => 'your url have to be a valid url' . "<br/>" . "<span class='val_error_small'>". '(try putting http:// or https:// or another prefix at the beginning)'. "</span>",
    //         ];


        $this->validate($request,[
            'copyright' => 'required',
            'designby'=>'required',
            'developerurl'=>'required'
            // 'developerurl' => array(
            //     'required',
            //     'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
            // )
             
        ]);



        Footer::query()->truncate();


        $create=Footer::create([
            'copyright' => $request['copyright'],
            'designby' =>  $request['designby'],
            'developerurl' => $request['developerurl']
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
        //
        return Footer::find($id);
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
