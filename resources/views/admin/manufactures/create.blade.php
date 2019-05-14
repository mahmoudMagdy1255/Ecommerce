@extends('admin.index')
@section('content')

@push('js')

      <script type="text/javascript" src="{{ url('/design/adminlte/dist/js/locationpicker.jquery.min.js') }}"></script>

      <?php
$lng = !empty(old('lng')) ? old('lng') : '31.219255447387695';
$lat = !empty(old('lat')) ? old('lat') : '30.061291199759854';
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
          }
        });


      </script>

@endpush

<div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {!! Form::open(['route' => 'manufactures.store' , 'files' => true ] ) !!}

              <input type="hidden" name="lat" id="lat" value="{{ $lat }}">
              <input type="hidden" name="lng" id="lng" value="{{ $lng }}">

              <div class="form-group">
                {!! Form::label('name_ar' ,  trans('admin.name_ar')) !!}
                {!! Form::text('name_ar' , old('name_ar') , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('name_en' ,  trans('admin.name_en')) !!}
                {!! Form::text('name_en' , old('name_en') , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('website' ,  trans('admin.website')) !!}
                {!! Form::text('website' , old('website') , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('contact_name' ,  trans('admin.contact_name')) !!}
                {!! Form::text('contact_name' , old('contact_name') , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('email' ,  trans('admin.email')) !!}
                {!! Form::email('email' , old('email') , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('mobile' ,  trans('admin.mobile')) !!}
                {!! Form::text('mobile' , old('mobile') , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('address' ,  trans('admin.address')) !!}
                {!! Form::text('address' , old('address') , ['class' => 'form-control address'] ) !!}
              </div>

              <div class="form-group">
                <div id="us1" style="width: 100%; height: 400px;"></div>
              </div>

              <div class="form-group">
                {!! Form::label('facebook' ,  trans('admin.facebook')) !!}
                {!! Form::text('facebook' , old('facebook') , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('twitter' ,  trans('admin.twitter')) !!}
                {!! Form::text('twitter' , old('twitter') , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('icon' ,  trans('admin.manufactures_logo') ) !!}
                {!! Form::file('icon' , ['class' => 'form-control'] ) !!}
              </div>

              {!! Form::submit( trans('admin.add') , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
          </div>
@endsection