@extends('admin.index')
@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

@push('js')


<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script type="text/javascript">

  $(document).ready(function() {

    $('.js-example-basic-single').select2();

    $(document).on('click', '.save_and_continue' , function(e) {

      var form_data = $('#product_form').serialize();

      $.ajax({
        url: '{{ aurl('/products/' . $product->id) }}',
        type: 'POST',
        dataType: 'json',
        data: form_data,
        beforeSend:function () {
          $('.loading_save_c').removeClass('hidden');
          $('.error_message').addClass('hidden');
          $('.validate_message').html('');

          $('.success_message').addClass('hidden');
          $('.success_message').html('');

        },
        success:function (data) {

          if (data.status == true) {

            $('.loading_save_c').addClass('hidden');
            $('.success_message').html( '<h1>' + data.message + '</h1>' ).removeClass('hidden')
          };

        },
        error:function (response) {
          $('.loading_save_c').addClass('hidden');

          var error_li = '';

          $.each(response.responseJSON.errors , function(index, value) {

            error_li += '<li>' + value + '<li>';

          });

          $('.error_message').removeClass('hidden');
          $('.validate_message').html(error_li);

        }
      });

      return false;

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
              {!! Form::open(['route' => 'products.store' , 'method' => 'PUT' , 'files' => true , 'id' => 'product_form' ] ) !!}

              <a href="#" class="btn btn-primary save" title="">{{ trans('admin.save') }} <i class="fa fa-floppy-o"></i> </a>
              <a href="#" class="btn btn-success save_and_continue" title="">{{ trans('admin.save_and_continue') }}
                <i class="fa fa-floppy-o"></i>
                <i class="fa fa-spin fa-spinner loading_save_c hidden"></i>
              </a>
              <a href="#" class="btn btn-info copy_product" title="">{{ trans('admin.copy_product') }}  <i class="fa fa-copy"></i></a>
              <a href="#" class="btn btn-danger delete" title="">{{ trans('admin.delete') }}  <i class="fa fa-trash"></i> </a>

              <hr>

                <div class="alert alert-success success_message hidden"></div>

                <div class="alert alert-danger error_message hidden">
                  <ul class="validate_message">

                  </ul>
                </div>

              <hr>

              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#product_info">{{ trans('admin.product_info') }} <i class="fa fa-info"></i></a></li>

                <li><a data-toggle="tab" href="#department">{{ trans('admin.department') }} <i class="fa fa-list"> </i></a></li>

                <li><a data-toggle="tab" href="#product_setting">{{ trans('admin.product_setting') }} <i class="fa fa-cog"> </i></a></li>

                <li><a data-toggle="tab" href="#product_media">{{ trans('admin.product_media') }} <i class="fa fa-photo"> </i></a></li>

                <li><a data-toggle="tab" href="#product_size_weight">{{ trans('admin.product_size_weight') }} <i class="fa fa-info-circle"></i> </a></li>

                <li><a data-toggle="tab" href="#other_data">{{ trans('admin.other_data') }} <i class="fa fa-database"> </i> </a></li>
              </ul>

              <div class="tab-content">

                @include('admin.products.tabs.product_info')
                @include('admin.products.tabs.department')
                @include('admin.products.tabs.product_setting')
                @include('admin.products.tabs.product_media')
                @include('admin.products.tabs.product_size_weight')
                @include('admin.products.tabs.other_data')

              </div>

              <a href="#" class="btn btn-primary save" title="">{{ trans('admin.save') }} <i class="fa fa-floppy-o"></i> </a>
              <a href="#" class="btn btn-success save_and_continue" title="">{{ trans('admin.save_and_continue') }} <i class="fa fa-floppy-o"></i></a>
              <a href="#" class="btn btn-info copy_product" title="">{{ trans('admin.copy_product') }}  <i class="fa fa-copy"></i></a>
              <a href="#" class="btn btn-danger delete" title="">{{ trans('admin.delete') }}  <i class="fa fa-trash"></i> </a>

              {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
          </div>
@endsection
