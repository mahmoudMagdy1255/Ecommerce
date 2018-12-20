@extends('admin.index')

@section('content')

<div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {!! Form::open(['route' => ['cities.update' , $city->id] , 'method' => 'PUT'] ) !!}

              <div class="form-group">
                {!! Form::label('city_name_ar' ,  trans('admin.city_name_ar')) !!}
                {!! Form::text('city_name_ar' , $city->city_name_ar , ['class' => 'form-control'] ) !!}  
              </div>

              <div class="form-group">
                {!! Form::label('city_name_en' ,  trans('admin.city_name_en')) !!}
                {!! Form::text('city_name_en' ,$city->city_name_en , ['class' => 'form-control'] ) !!}  
              </div>

              <div class="form-group">
                {!! Form::label('country_id' ,  trans('admin.country_id') ) !!}
                {!! Form::select('country_id' , App\Model\Country::pluck('country_name_'. lang() , 'id') , $city->country_id , ['class' => 'form-control'] ) !!}  
              </div>

              
              {!! Form::submit( trans('admin.save') , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
          </div>
@endsection