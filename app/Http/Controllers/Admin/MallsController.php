<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\MallsDatatable;
use App\Model\Mall;
use Storage;

class MallsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MallsDatatable $MallsDatatable)
    {
        return $MallsDatatable->render('admin.malls.index' , ['title' => trans('admin.malls')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.malls.create' , ['title' => trans('admin.create_mall')]);
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
            'name_ar' => 'required',
            'name_en'=> 'required',
            'facebook'  => 'sometimes|nullable|url',
            'twitter'  => 'sometimes|nullable|url',
            'country_id'  => 'required|numeric',
            'website'  => 'sometimes|nullable|url',
            'contact_name'  => 'sometimes|nullable',
            'mobile'  => 'required|numeric',
            'address'  => 'required',
            'email'  => 'required|email',
            'lat'  => 'sometimes|nullable',
            'lng'  => 'sometimes|nullable',
            'icon'=>'sometimes|nullable|' . v_image(),
        ] , [] , [

            'name_ar' => trans('admin.name_ar'),
            'name_en'=> trans('admin.name_en'),
            'country_id'  => trans('admin.country_id'),
            'facebook'=> trans('admin.facebook'),
            'twitter' => trans('admin.twitter'),
            'website'=> trans('admin.website'),
            'contact_name'=> trans('admin.contact_name'),
            'mobile'=> trans('admin.mobile'),
            'address'=> trans('admin.address'),
            'email'=> trans('admin.email'),
            'lat' => trans('admin.lat'),
            'lng'=> trans('admin.lng'),
            'icon'=> trans('admin.icon'),
        ]);

        if ( request()->hasFile('icon') ) {
            $data['icon'] = upload([
                'file' => 'icon',
                'path' => 'malls',
                'upload_type' => 'single',
                'delete_file' => '',
            ]);
        }

        Mall::create($data);
        session()->flash('success' , trans('admin.record_added') );
        return redirect(aurl('malls'));
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
        $mall = Mall::find($id);
        $title = trans('admin.edit');

        return view('admin.malls.edit' , compact('title' , 'mall') );
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
            'name_ar' => 'required',
            'name_en'=> 'required',
            'country_id'  => 'required|numeric',
            'facebook'  => 'sometimes|nullable|url',
            'twitter'  => 'sometimes|nullable|url',
            'website'  => 'sometimes|nullable|url',
            'contact_name'  => 'sometimes|nullable',
            'mobile'  => 'required|numeric',
            'address'  => 'required',
            'email'  => 'required|email',
            'lat'  => 'sometimes|nullable',
            'lng'  => 'sometimes|nullable',
            'icon'=>'sometimes|nullable|' . v_image(),
        ] , [] , [

            'name_ar' => trans('admin.name_ar'),
            'name_en'=> trans('admin.name_en'),
            'country_id'  => trans('admin.country_id'),
            'facebook'=> trans('admin.facebook'),
            'twitter' => trans('admin.twitter'),
            'website'=> trans('admin.website'),
            'contact_name'=> trans('admin.contact_name'),
            'mobile'=> trans('admin.mobile'),
            'address'=> trans('admin.address'),
            'email'=> trans('admin.email'),
            'lat' => trans('admin.lat'),
            'lng'=> trans('admin.lng'),
            'icon'=> trans('admin.icon'),
        ]);

        if ( request()->hasFile('icon') ) {
            $data['icon'] = upload([
                'file' => 'icon',
                'path' => 'malls',
                'upload_type' => 'single',
                'delete_file' => Mall::find($id)->icon
            ]);
        }

        Mall::whereId($id)->update($data);
        session()->flash('success' , trans('admin.updated_record') );
        return redirect(aurl('malls'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mall = Mall::find($id);

        Storage::delete( $mall->icon );

        $mall->delete();

        session()->flash('success' , trans('admin.deleted_record') );
        return redirect(aurl('malls'));
    }

    public function multi_delete()
    {
        if( is_array(request('item')) ){

            foreach (request('item') as $id) {
                $mall = Mall::find($id);

                Storage::delete( $mall->icon );

                $mall->delete();
            }

        }else{
            $mall = Mall::find( request('item') );

            Storage::delete( $mall->icon );

            $mall->delete();
        }

        session()->flash('success' , trans('admin.deleted_record') );
        return redirect(aurl('malls'));
    }
}
