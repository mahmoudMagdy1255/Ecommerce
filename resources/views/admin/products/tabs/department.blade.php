@push('js')

<script>

  $(function () {

    $('#jstree').jstree({

      "core" : {
        'data' : {!! load_dep( $product->department_id ) !!},
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

      var dep_id = r.join(', ') ;

      if(dep_id != '' ){
        $('.department_id').val( dep_id );
      }

      $.ajax({
        url: '{{ aurl('/load/weight/size') }}',
        type: 'POST',
        dataType: 'html',
        data: {_token: '{{ csrf_token() }}' , dep_id:dep_id , product_id : "{{ $product->id }}" },
      })
      .done(function(data) {
        $('.size_weight').html(data);
        $('.info_data').removeClass('hidden');
      })
      .fail(function() {
        console.log("error");
      });


    });

  });

</script>

@endpush

<div id="department" class="tab-pane fade">
	<h3>{{ trans('admin.department') }}</h3>
	<div id="jstree"></div>
	<input type="hidden" name="department_id" class="department_id">
</div>