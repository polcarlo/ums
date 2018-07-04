<?php

namespace App\Http\Controllers;
use App\Role;
use App\User;
use App\User_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use Response;
class UsersController extends Controller
{



    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function index()
    {
        //
         $users = $this->user->get();
         $roles = $this->role->get();
/*        $users = User::join('roles','roles.id','=','users.role_id')
                ->select('users.*','roles.name as role_name')->get(); */
        return view('user/uHome', compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->role::all();
         return view('auth/register',compact('roles'));
         redirect('users');
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
         $data = $request->except('_token');
        if($request->ajax())
        {
           // $user = User::create($request->all());
            $user = $this->user::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
           // 'role_id'=> $request->input('roles'),
        ]);

        $user_role = count($request->get('p_id'));
        for($i=0; $i < $user_role; $i++){
            $ur = new User_role;
           $ur->role_id = $data['p_id'][$i];
            $ur->user_id = $user->id;
            $ur->save();
        }
            return response($user);
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
        //
         if($request->ajax())
        {
            $role = $this->user::select('*')->where('id',$request->id)->first(); 
            $role2 = $this->user::select('r.id as id')
            ->join('user_roles as ur','ur.user_id','=','users.id')
            ->join('roles as r','r.id','=','ur.role_id')
            ->where('users.id','=', $request->id)->get()->toArray();
            $count_role = count($role2);
           return Response::json(array('role'=>$role,'role2'=>$role2,'cr'=>$count_role));
          /// $student->update($request->all());
//            return response($roles,$roles2);
        
            //return response($roles);
        
            //  return view('user/updateUser', compact('roles2'));
        }
    }





    public function roles_details()
    {
             
               return view('user/updateUser', compact('roles2'));
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
            $role = User::find($request->id);
            
            $role->update([

                'name' =>  $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
        //    $role->update($request->all());
            $role_permission = count($request->get('u_id'));
            for($i=0; $i < $role_permission; $i++){
             $rp = new User_role;
            $rp->role_id = $data['u_id'][$i];
            $rp->user_id = $role->id;
            $rp->save();
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
             $this->user::destroy($request->id);
            return response(['message'=>'Deleted']);
            
         }

        
    }



}

