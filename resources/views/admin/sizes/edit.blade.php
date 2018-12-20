@extends('admin.index')

@section('content')

@push('js')

<script>

  $(function () { 

    $('#jstree').jstree({
      
      "core" : {
        'data' : {!! load_dep( $size->department_id ) !!},
        "themes" : {
          "variant" : "large"
        }
      },
      "checkbox" : {
        "keep_selected_style" : true
      },
      "plugins" : [ "wholerow" ]
    });

    $('#jstree').on('changed.jstree' , function(e , data) {
      
      var i , j , r = [];
      var name = [];

      for (var i = 0 , j = data.selected.length ; i < j ; i++) {

        r.push( data.instance.get_node(data.selected[i]).id );

      };

      if(r.join(', ') != '' ){
        $('.department_id').val( r.join(', ') );
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
              {!! Form::open(['route' => ['sizes.update' , $size->id] , 'method' => 'PUT' , 'files' => true ] ) !!}
              
              <div class="form-group">
                {!! Form::label('name_ar' ,  trans('admin.name_ar')) !!}
                {!! Form::text('name_ar' , $size->name_ar , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('name_en' ,  trans('admin.name_en')) !!}
                {!! Form::text('name_en' ,$size->name_en , ['class' => 'form-control'] ) !!}
              </div>

              {!! Form::hidden('department_id' , $size->department_id , ['class' => 'department_id'] ) !!}
              
              
              <div id="jstree"></div>

              <div class="form-group">
                {!! Form::label('is_public' ,  trans('admin.is_public')) !!}
                {!! Form::select('is_public' , ['yes' => trans('admin.yes') , 'no' => trans('admin.no') ] , $size->is_public , ['class' => 'form-control'] ) !!}
              </div>
              

              {!! Form::submit( trans('admin.save') , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
          </div>
@endsection
