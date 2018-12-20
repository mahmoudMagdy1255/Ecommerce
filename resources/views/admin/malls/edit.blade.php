@extends('admin.index')

@section('content')

@push('js')

      <script type="text/javascript" src='https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyBwxuW2cdXbL38w9dcPOXfGLmi1J7AVVB8'></script>

      <script type="text/javascript" src="{{ url('/design/adminlte/dist/js/locationpicker.jquery.min.js') }}"></script>

      <?php
        $lng = !empty( old('lng') ) ? old('lng') : $mall->lng;
        $lat = !empty( old('lat') ) ? old('lat') : $mall->lat;
      ?>

      <script>

        $('#us1').locationpicker({
          location: {
              latitude: {{ $lat }},
              longitude: {{ $lng }}
          },
            radius: 300,
            markerIcon: '{{ url('/design/adminlte/dist/img/map-marker-2-xl.png') }}',
            inputBinding: {
            latitudeInput: $('#lat'),
            longitudeInput: $('#lng'),
            //radiusInput: $('#us2-radius'),
            locationNameInput: $('.address')
          },
          enableAutocomplete:true
        });

      </script>

@endpush

<div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {!! Form::open(['route' => ['malls.update' , $mall->id] , 'method' => 'PUT' , 'files' => true ] ) !!}
              <input type="hidden" name="lat" id="lat" value="{{ $lat }}">
              <input type="hidden" name="lng" id="lng" value="{{ $lng }}">

              <div class="form-group">
                {!! Form::label('name_ar' ,  trans('admin.name_ar')) !!}
                {!! Form::text('name_ar' , $mall->name_ar , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('name_en' ,  trans('admin.name_en')) !!}
                {!! Form::text('name_en' ,$mall->name_en , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('website' ,  trans('admin.website')) !!}
                {!! Form::text('website' , $mall->website , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('contact_name' ,  trans('admin.contact_name')) !!}
                {!! Form::text('contact_name' , $mall->contact_name , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('email' ,  trans('admin.email')) !!}
                {!! Form::email('email' , $mall->email , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('mobile' ,  trans('admin.mobile')) !!}
                {!! Form::text('mobile' , $mall->mobile , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('address' ,  trans('admin.address')) !!}
                {!! Form::text('address' , $mall->address , ['class' => 'form-control address'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('country_id' ,  trans('admin.country_id') ) !!}
                {!! Form::select('country_id' , App\Model\Country::pluck('country_name_'. lang() , 'id') , $mall->country_id , ['class' => 'form-control'] ) !!}  
              </div>

              <div class="form-group">
                <div id="us1" style="width: 100%; height: 400px;"></div>
              </div>

              <div class="form-group">
                {!! Form::label('facebook' ,  trans('admin.facebook')) !!}
                {!! Form::text('facebook' , $mall->facebook , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('twitter' ,  trans('admin.twitter')) !!}
                {!! Form::text('twitter' , $mall->twitter , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('icon' ,  trans('admin.mall_logo') ) !!}
                {!! Form::file('icon' , ['class' => 'form-control'] ) !!}
              </div>

              @if( !empty($mall->icon) )
                <img src="{{ Storage::url( $mall->icon ) }}" alt="Logo" style="width: 50px; height: 50px">
              @endif

              {!! Form::submit( trans('admin.save') , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
          </div>
@endsection
