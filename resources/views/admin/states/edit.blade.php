@extends('admin.index')

@section('content')


@push('js')

<script>
  
  var country;

  $(function(){

      $.ajax({
          url: '{{ aurl('states/create') }}',
          type: 'GET',
          dataType: 'html',
          data : {country_id : {{ $state->country_id }} , select : {{ $state->city_id }} },
        }).done(function(data){
 
            $('.city').html(data); 

        });


    $('.country_id').on('change', function() {

      country = $('.country_id option:selected').val();
      
      if (country > 0) {

        $.ajax({
          url: '{{ aurl('states/create') }}',
          type: 'GET',
          dataType: 'html',
          data : {country_id : country , select : ''},
        }).done(function(data){

            $('.city').html(data);  

        });
        
      }else {
        $('.city').html('');
      }
    });

  });

</script>
@endpush


<div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {!! Form::open(['route' => ['states.update' , $state->id] , 'method' => 'PUT'] ) !!}

              <div class="form-group">
                {!! Form::label('state_name_ar' ,  trans('admin.state_name_ar')) !!}
                {!! Form::text('state_name_ar' , $state->state_name_ar , ['class' => 'form-control'] ) !!}  
              </div>

              <div class="form-group">
                {!! Form::label('state_name_en' ,  trans('admin.state_name_en')) !!}
                {!! Form::text('state_name_en' ,$state->state_name_en , ['class' => 'form-control'] ) !!}  
              </div>

              <div class="form-group">
                {!! Form::label('country_id' ,  trans('admin.country_id') ) !!}
                {!! Form::select('country_id' , App\Model\Country::pluck('country_name_'. lang() , 'id') , $state->country_id , ['class' => 'form-control country_id' , 'placeholder' => ''] ) !!}  
              </div>

              <div class="form-group">
                {!! Form::label('city_id' ,  trans('admin.city_id') ) !!}
                <span class="city"></span> 
              </div>

              
              {!! Form::submit( trans('admin.save') , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
          </div>
@endsection