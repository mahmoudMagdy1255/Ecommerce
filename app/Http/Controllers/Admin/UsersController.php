<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\UsersDatatable;
use App\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDatatable $UsersDatatable)
    {
        return $UsersDatatable->render('admin.users.index' , ['title' => trans('admin.users') ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create' , ['title' => trans('admin.add')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate( request() , [
            'name' => 'required',
            'level' => 'required|in:user,vendor,company',
            'email'=> 'required|email|unique:users,email',
            'password'=>'required|min:6'
        ] , [] , [
            'name' => trans('admin.name'),
            'level' => trans('admin.level'),
            'email' => trans('admin.email'),
            'password' => trans('admin.password'),
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);
        session()->flash('success' , trans('admin.user_added') );
        return redirect(aurl('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $title = trans('admin.edit');

        return view('admin.users.edit' , compact('title' , 'user') );
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
        $data = $this->validate( request() , [
            'name' => 'required',
            'level' => 'required|in:user,vendor,company',
            'email'=> 'required|email|unique:users,email,'. $id,
            'password'=>'sometimes|nullable|min:6'
        ] , [] , [
            'name' => trans('admin.name'),
            'level' => trans('admin.level'),
            'email' => trans('admin.email'),
            'password' => trans('admin.password'),
        ]);

        if(session('password')){
            $data['password'] = bcrypt($data['password']);    
        }else{
            unset($data['password']);
        }

        User::where('id' , $id)->update($data);
        session()->flash('success' , trans('admin.users_updated') );
        return redirect(aurl('users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        session()->flash('success' , trans('admin.admin_deleted') );
        return redirect(aurl('users'));
    }

    public function multi_delete()
    {
        if( is_array(request('item')) ){
            User::destroy( request('item') );
        }else{
            User::find(request('item'))->delete();
        }

        session()->flash('success' , trans('admin.users_deleted') );
        return redirect(aurl('users'));
    }
}
