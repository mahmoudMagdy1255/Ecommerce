@push('js')

<script>

	$('.datepicker').datepicker({
		rtl: {{ lang() == 'ar' ? true : false }},
		language: '{{ lang() }}',
		format:'yyyy-mm-dd',
		autoclose:false,
		todayBtn:true,
		clearBtn:true
	});

  $('#status').on('change', function() {

    var status = $('#status option:selected').val();

    if (status == 'refused') {

      $('.reason').removeClass('hidden');

    }else {

        $('.reason').addClass('hidden');


    }

  });


</script>

@endpush

<div id="product_setting" class="tab-pane fade">
    <h3>{{ trans('admin.product_setting') }}</h3>

    <div class="form-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
     {!! Form::label('price' ,  trans('admin.price')) !!}
     {!! Form::text('price' , $product->price , ['class' => 'form-control', 'placeholder' => trans('admin.price')] ) !!}
  	</div>

  	<div class="form-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
     {!! Form::label('stock' ,  trans('admin.stock')) !!}
     {!! Form::text('stock' , $product->stock , ['class' => 'form-control', 'placeholder' => trans('admin.stock')] ) !!}
  	</div>

  	<div class="form-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
     {!! Form::label('start_at' ,  trans('admin.start_at')) !!}
     {!! Form::text('start_at' , $product->start_at , ['class' => 'form-control datepicker','autocomplete' => 'off', 'placeholder' => trans('admin.start_at')] ) !!}
  	</div>

  	<div class="form-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
     {!! Form::label('end_at' ,  trans('admin.end_at')) !!}
     {!! Form::text('end_at' , $product->end_at , ['class' => 'form-control datepicker','autocomplete' => 'off' , 'placeholder' => trans('admin.end_at')] ) !!}
  	</div>

  	<div class="clearfix"></div>
	<hr>

  	<div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-12">
     {!! Form::label('price_offer' ,  trans('admin.price_offer')) !!}
     {!! Form::text('price_offer' , $product->price_offer , ['class' => 'form-control', 'placeholder' => trans('admin.price_offer')] ) !!}
  	</div>

  	<div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-12">
     {!! Form::label('start_offer_at' ,  trans('admin.start_offer_at')) !!}
     {!! Form::text('start_offer_at' , $product->start_offer_at , ['class' => 'form-control datepicker','autocomplete' => 'off', 'placeholder' => trans('admin.start_offer_at')] ) !!}
  	</div>

  	<div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-12">
     {!! Form::label('end_offer_at' ,  trans('admin.end_offer_at')) !!}
     {!! Form::text('end_offer_at' , $product->end_offer_at , ['class' => 'form-control datepicker','autocomplete' => 'off', 'placeholder' => trans('admin.end_offer_at')] ) !!}
  	</div>

  	<div class="clearfix"></div>
	<hr>

  	<div class="form-group">
     {!! Form::label('status' ,  trans('admin.status')) !!}
     {!! Form::select('status' , ['pending' => trans('admin.pending') , 'refused' =>trans('admin.refused') , 'active' => trans('admin.active') ] ,
        ['class' => 'form-control', 'placeholder' => trans('admin.status')] ) !!}
  	</div>

  	<div class="form-group reason {{ $product->status != 'refused' ? 'hidden' : '' }}">
     {!! Form::label('refused_reason' ,  trans('admin.refused_reason')) !!}
     {!! Form::textarea('refused_reason' , $product->refused_reason , ['class' => 'form-control', 'placeholder' => trans('admin.refused_reason')] ) !!}
  	</div>


</div>