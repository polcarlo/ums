<?php

namespace App\Http\Controllers;
use App\Permission;
use App\Role;
use App\Role_permission;
use Illuminate\Http\Request;
use Response;


class RoleController extends Controller
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
        
        $roles = Role::get();

        $permission = Permission::get();
        return view('role/home', compact('roles','permission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    public function find($id)
    {
      
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->except('_token');
        // $roles = DB::table('roles')->insert(['name'=>'sdfgsdf']);
        if($request->ajax())
        {
            $role = Role::create($request->all());
      
        $role_permission = count($request->get('p_id'));
        for($i=0; $i < $role_permission; $i++){
 
            $rp = new Role_permission;
            $rp->permission_id = $data['p_id'][$i];
            $rp->role_id = $role->id;
            $rp->save();
        }

           return response($role);

        }
    }

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
            $role = Role::find($request->id)->toArray();
            $role2 = Role::select('p.id as id','rp.id as rpid')
            ->join('role_permissions as rp','rp.role_id','=','roles.id')
            ->join('permissions as p','p.id','=','rp.permission_id')
            ->where('roles.id','=', $request->id)->get()->toArray();
            $count_role = count($role2);
           return Response::json(array('role'=>$role,'role2'=>$role2,'cr'=>$count_role));
           //return response($role2);
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
            $data = $request->except('_token');
            $role = Role::find($request->id);
            $role->update($request->all());

            $role_permission = count($request->get('up_id'));
            for($i=0; $i < $role_permission; $i++){
             //   $rpid = Role_permission::where('id',$request->rpid)
             //   $rpid = Role_permission::find();
                    //  ;
               // if(!empty($data['rpid'][$i])){
                $rp = new Role_permission;
                $rp->permission_id = $data['up_id'][$i];
                $rp->role_id = $role->id;
                $rp->save();
             //   }
                  if(empty($data['up_id'][$i])){
                  Role_permission::destroy($data['rpid'][$i]);
                }
        

        }
  


            return response($role);
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
            Role::destroy($request->id);
           return response(['message'=>'Deleted']);
        }
        
    }
}
