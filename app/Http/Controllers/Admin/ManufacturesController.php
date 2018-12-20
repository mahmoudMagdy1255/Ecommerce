<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\ManufactsDatatable;
use App\Model\Manufactures;
use Storage;

class ManufacturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManufactsDatatable $ManufactsDatatable)
    {
        return $ManufactsDatatable->render('admin.manufactures.index' , ['title' => trans('admin.manufactures')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.manufactures.create' , ['title' => trans('admin.create_manufactures')]);
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
                'path' => 'manufactures',
                'upload_type' => 'single',
                'delete_file' => '',
            ]);
        }

        Manufactures::create($data);
        session()->flash('success' , trans('admin.record_added') );
        return redirect(aurl('manufactures'));
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
        $manufacture = Manufactures::find($id);
        $title = trans('admin.edit');

        return view('admin.manufactures.edit' , compact('title' , 'manufacture') );
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
                'path' => 'manufactures',
                'upload_type' => 'single',
                'delete_file' => Manufactures::find($id)->icon
            ]);
        }

        Manufactures::whereId($id)->update($data);
        session()->flash('success' , trans('admin.updated_record') );
        return redirect(aurl('manufactures'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manufactures = Manufactures::find($id);
        
        Storage::delete( $manufactures->icon );

        $manufactures->delete();
        
        session()->flash('success' , trans('admin.deleted_record') );
        return redirect(aurl('manufactures'));
    }

    public function multi_delete()
    {
        if( is_array(request('item')) ){

            foreach (request('item') as $id) {
                $manufactures = Manufactures::find($id);
        
                Storage::delete( $manufactures->icon );

                $manufactures->delete();
            }

        }else{
            $manufactures = Manufactures::find( request('item') );
        
            Storage::delete( $manufactures->icon );

            $manufactures->delete();
        }

        session()->flash('success' , trans('admin.deleted_record') );
        return redirect(aurl('manufactures'));
    }
}
