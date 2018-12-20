<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\ShippingsDatatable;
use App\Model\Shipping;
use Storage;

class ShippingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ShippingsDatatable $ShippingsDatatable)
    {
        return $ShippingsDatatable->render('admin.shippings.index' , ['title' => trans('admin.shippings')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shippings.create' , ['title' => trans('admin.create_shippings')]);
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
            'user_id'  => 'required|numeric',
            'lat'  => 'sometimes|nullable',
            'lng'  => 'sometimes|nullable',
            'icon'=>'sometimes|nullable|' . v_image(),
        ] , [] , [

            'name_ar' => trans('admin.name_ar'),
            'name_en'=> trans('admin.name_en'),
            'user_id'=> trans('admin.user_id'),
            'lat' => trans('admin.lat'),
            'lng'=> trans('admin.lng'),
            'icon'=> trans('admin.icon'),
        ]);

        if ( request()->hasFile('icon') ) {
            $data['icon'] = upload([
                'file' => 'icon',
                'path' => 'shippings',
                'upload_type' => 'single',
                'delete_file' => '',
            ]);
        }

        Shipping::create($data);
        session()->flash('success' , trans('admin.record_added') );
        return redirect(aurl('shippings'));
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
        $Shipping = Shipping::find($id);
        $title = trans('admin.edit');

        return view('admin.shippings.edit' , compact('title' , 'Shipping') );
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
            'user_id'  => 'required|numeric',
            'lat'  => 'sometimes|nullable',
            'lng'  => 'sometimes|nullable',
            'icon'=>'sometimes|nullable|' . v_image(),
        ] , [] , [

            'name_ar' => trans('admin.name_ar'),
            'name_en'=> trans('admin.name_en'),
            'user_id'=> trans('admin.user_id'),
            'lat' => trans('admin.lat'),
            'lng'=> trans('admin.lng'),
            'icon'=> trans('admin.icon'),
        ]);

        if ( request()->hasFile('icon') ) {
            $data['icon'] = upload([
                'file' => 'icon',
                'path' => 'shippings',
                'upload_type' => 'single',
                'delete_file' => Shipping::find($id)->icon
            ]);
        }

        Shipping::whereId($id)->update($data);
        session()->flash('success' , trans('admin.updated_record') );
        return redirect(aurl('shippings'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Shipping = Shipping::find($id);
        
        Storage::delete( $Shipping->icon );

        $Shipping->delete();
        
        session()->flash('success' , trans('admin.deleted_record') );
        return redirect(aurl('shippings'));
    }

    public function multi_delete()
    {
        if( is_array(request('item')) ){

            foreach (request('item') as $id) {
                $shippings = Shipping::find($id);
        
                Storage::delete( $shippings->icon );

                $shippings->delete();
            }

        }else{
            $shippings = Shipping::find( request('item') );
        
            Storage::delete( $shippings->icon );

            $shippings->delete();
        }

        session()->flash('success' , trans('admin.deleted_record') );
        return redirect(aurl('shippings'));
    }
}
