@extends('admin.index')

@section('content')

<div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {!! Form::open(['route' => ['countries.update' , $trademark->id] , 'method' => 'PUT' , 'files' => true ] ) !!}

              <div class="form-group">
                {!! Form::label('name_ar' ,  trans('admin.name_ar')) !!}
                {!! Form::text('name_ar' , $trademark->name_ar , ['class' => 'form-control'] ) !!}  
              </div>

              <div class="form-group">
                {!! Form::label('name_en' ,  trans('admin.name_en')) !!}
                {!! Form::text('name_en' ,$trademark->name_en , ['class' => 'form-control'] ) !!}  
              </div>

              <div class="form-group">
                {!! Form::label('logo' ,  trans('admin.trade_icon') ) !!}
                {!! Form::file('logo' , ['class' => 'form-control'] ) !!}  
              </div>

              @if( !empty($trademark->logo) )
                <img src="{{ Storage::url( $trademark->logo ) }}" alt="Logo" style="width: 50px; height: 50px">
              @endif
              
              {!! Form::submit( trans('admin.save') , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
          </div>
@endsection