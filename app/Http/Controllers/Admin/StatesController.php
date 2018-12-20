<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\statesDatatable;
use App\Model\State;
use App\Model\City;
use Form;
use Storage;

class StatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(statesDatatable $statesDatatable)
    {
        return $statesDatatable->render('admin.states.index' , ['title' => trans('admin.states')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->ajax() ) {

            if (request('country_id')) {
                
                $select = request('select') ? request('select') : '';

                return Form::select('city_id' , City::where('country_id' , request('country_id') )->pluck('city_name_' . lang() , 'id') , $select , ['class' => 'form-control', 'placeholder' => '']); 
            }
        }

        return view('admin.states.create' , ['title' => trans('admin.create_states')]);
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
            'state_name_ar' => 'required',
            'state_name_en'=> 'required',
            'country_id'=> 'required|numeric',
            'city_id'=> 'required|numeric',
        ] , [] , [

            'state_name_ar' => trans('admin.state_name_ar'),
            'state_name_en'=> trans('admin.state_name_en'),
            'country_id'=> trans('admin.country_id'),
            'city_id'=> trans('admin.city_id'),
        ]);


        State::create($data);
        session()->flash('success' , trans('admin.record_added') );
        return redirect(aurl('states'));
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
        $state = State::find($id);
        $title = trans('admin.edit');

        return view('admin.states.edit' , compact('title' , 'state') );
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
            'state_name_ar' => 'required',
            'state_name_en'=> 'required',
            'country_id'=> 'required|numeric',
            'city_id'=> 'required|numeric',
        ] , [] , [

            'state_name_ar' => trans('admin.state_name_ar'),
            'state_name_en'=> trans('admin.state_name_en'),
            'country_id'=> trans('admin.country_id'),
            'city_id'=> trans('admin.city_id'),
        ]);

      
        State::whereId($id)->update($data);
        session()->flash('success' , trans('admin.updated_record') );
        return redirect(aurl('states'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $states = State::find($id);
        $states->delete();
        
        session()->flash('success' , trans('admin.deleted_record') );
        return redirect(aurl('states'));
    }

    public function multi_delete()
    {
        if( is_array(request('item')) ){

            foreach (request('item') as $id) {
                $states = State::find($id);
                $states->delete();
            }

        }else{
            $states = State::find( request('item') );
            $states->delete();
        }

        session()->flash('success' , trans('admin.deleted_record') );
        return redirect(aurl('states'));
    }
}
