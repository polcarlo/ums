<?php

namespace App\Http\Controllers;
use App\Permission;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function __construct(){
         $this->middleware('auth');
    }
    public function index()
    {
        //
      //  $permissions = Permission::get(); 
        return view('permission.pHome');
    }

    public function get_datatable()

    {
           $users = Permission::select(['id','name']);
       return Datatables::of($users)->make();
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
          if($request->ajax())
        {
            $permission = Permission::create($request->all());
            return response($permission);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if($request->ajax())
        {
            $permission = Permission::find($request->id);
   
            return response($permission);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 public function update(Request $request)
    {
        if($request->ajax())
        {
            $permission = permission::find($request->id);
            $permission->update($request->all());

            return response($permission);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
              if($request->ajax())
        {
            Permission::destroy($request->id);
           return response(['message'=>'Deleted']);
        }
    }
}
