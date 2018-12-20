<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Department;
use Storage;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.departments.index' , ['title' => trans('admin.departments')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.departments.create' , ['title' => trans('admin.add')]);
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
            'dep_name_ar' => 'required',
            'dep_name_en' => 'required',
            'icon'        => 'sometimes|nullable|' . v_image(),
            'description' => 'sometimes|nullable',
            'keyword'     => 'sometimes|nullable',
            'parent'   => 'sometimes|nullable|numeric',
        ] , [] , [

            'dep_name_ar' => trans('admin.dep_name_ar'),
            'dep_name_en' => trans('admin.dep_name_en'),
            'icon'        => trans('admin.icon'),
            'description' => trans('admin.description'),
            'keyword'     => trans('admin.keyword'),
            'parent'   => trans('admin.parent'),
        ]);

        if (request()->hasFile('icon')) {
            $data['icon'] = upload([
                'file' => 'icon',
                'path' => 'departments',
                'upload_type' => 'single',
                'delete_file' => '',
            ]);
        }


        Department::create($data);
        session()->flash('success' , trans('admin.record_added') );
        return redirect(aurl('departments'));
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
        $department = Department::find($id);
        $title = trans('admin.edit');

        return view('admin.departments.edit' , compact('title' , 'department') );
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
            'dep_name_ar' => 'required',
            'dep_name_en' => 'required',
            'icon'        => 'sometimes|nullable|' . v_image(),
            'description' => 'sometimes|nullable',
            'keyword'     => 'sometimes|nullable',
            'parent'   => 'sometimes|nullable|numeric',
        ] , [] , [

            'dep_name_ar' => trans('admin.dep_name_ar'),
            'dep_name_en' => trans('admin.dep_name_en'),
            'icon'        => trans('admin.icon'),
            'description' => trans('admin.description'),
            'keyword'     => trans('admin.keyword'),
            'parent'   => trans('admin.parent'),
        ]);

        $department = Department::find($id);

        if (request()->hasFile('icon')) {
            $data['icon'] = upload([
                'file' => 'icon',
                'path' => 'departments',
                'upload_type' => 'single',
                'delete_file' => $department->icon,
            ]);
        }

        Department::whereId($id)->update($data);
        session()->flash('success' , trans('admin.updated_record') );
        return redirect(aurl('departments'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public static function delete_department($id)
    {
        $sub_departments = Department::where('parent' , $id)->get();

        foreach ($sub_departments as $sub) {
            
            self::delete_department($sub->id);

            if( !empty($sub->icon) ){
                Storage::has($sub->icon) ? Storage::delete($sub->icon) : '';
            }

            $sub->delete();
        }

        $dep = Department::find($id);

        if( !empty($dep->icon) ){
            Storage::has($dep->icon) ? Storage::delete($dep->icon) : '';
        }

        $dep->delete();

    }

    public function destroy($id)
    {
        self::delete_department($id);
        
        session()->flash('success' , trans('admin.deleted_record') );
        return redirect(aurl('departments'));
    }


}
