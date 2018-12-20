@extends('admin.index')

@section('content')

@push('js')

<div id="delete_bootstrap_model" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ trans('admin.delete') }}</h4>
      </div>
      {!! Form::open(['url'=> '' ,'method'=>'DELETE' , 'id' => 'form_delete_department']) !!}
      <div class="modal-body">

        <h4>{{ trans('admin.ask_delete_dep') }} </h4>
        <span id="dep_name">  </span>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">{{ trans('admin.close') }}</button>
        {!! Form::submit(trans('admin.yes'),['class'=>'btn btn-danger']) !!}
      </div>
      {!! Form::close() !!}
    </div>

  </div>
</div>

<script>

  $(function () { 

    $('#jstree').jstree({
      
      "core" : {
        'data' : {!! load_dep() !!},
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
        name.push( data.instance.get_node(data.selected[i]).text );

      };

      if(r.join(', ') != '' ){
        $('.showbtn_control').removeClass('hidden');
        $('.edit_dep').attr('href', '{{ aurl('departments')  }}/' + r.join(', ') + '/edit');
      }else {
        $('.showbtn_control').addClass('hidden');

      }

      $('#form_delete_department').attr('action' , '{{ aurl('departments/') }}/' + r.join(', ') );
      $('#dep_name').text(name.join(', ') );

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
              <a href="" class="btn btn-info edit_dep showbtn_control hidden" >
                <i class="fa fa-edit"></i> {{trans('admin.edit') }}
              </a>
              <a href="" class="btn btn-danger delete_dep showbtn_control hidden" data-toggle="modal" data-target="#delete_bootstrap_model">
                <i class="fa fa-trash"></i> {{trans('admin.delete')}}
              </a>
               <div id="jstree"></div>
            </div>
            <!-- /.box-body -->
          </div>

@endsection