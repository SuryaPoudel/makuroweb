<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ControlPanelRole;


class ControlPanelRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //        
        $Users = ControlPanelRole::select('*')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

            return $Users;
    }

public function SearchUser()
{
    $searchkey = \Request::get('q');
    $Users = ControlPanelRole::select('*')
    ->orderBy('created_at', 'desc')
    ->where('name','LIKE',"%$searchkey%")
    ->paginate(20);

    return $Users;

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
       

        $this->validate($request,[
            'name' => 'required',
            'email'=>'required|email',
            'password'=>'required|string|min:5'
        
             
        ]);


        $email=ControlPanelRole::where('email', '=', $request->input('email'))->first();

      // return $email;
        if ($email === null) {

        $permission='';
        foreach($request['permission'] as $value)
        {
            $permission.=$value.',';
        }

       $permission=substr_replace($permission,"",-1);


        $create=ControlPanelRole::create([
            'name' => $request['name'],
            'email' =>  $request['email'],
            'password' => $request['password'],
            'permission' =>$permission
        ]);


        }
        else
        {
            return  ['status'=>false,'msg'=>'This email has already account.'];

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
         return ControlPanelRole::find($id);
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

        $controlPanel_control=ControlPanelRole::findOrFail($id);
        $input=$request->all();


    
        $this->validate($request,[
            'name' => 'required',
            'email'=>'required|email',
            'password'=>'required|string|min:5'
        
             
        ]);

        $permission='';
        foreach($request['permission'] as $value)
        {
            $permission.=$value.',';
        }

        $permission=substr_replace($permission,"",-1);

        $input['name']=$request->input('name');
        $input['email']=$request->input('email');
        $input['password']=$request->input('password');
        $input['permission']=$request->$permission;
        

         $controlPanel_control->update($input);
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

        $user = ControlPanelRole::find($id);
        $user->delete();
        return ['status'=>true,'msg'=>'Deleted Sucessfully.'];
    }
}
