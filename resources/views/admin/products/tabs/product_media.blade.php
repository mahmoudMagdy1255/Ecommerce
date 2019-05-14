@push('js')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

<script type="text/javascript">

	Dropzone.autoDiscover = false;

	$('#dropzoneFileUpload').dropzone({
		url:"{{ aurl('upload/image/' . $product->id) }}",
		paramName:'file',
		uploadMultiple:false,
		maxFile:1,
		maxFilesize:4,
		acceptedFiles:'image/*',
		dictDefaultMessage:'اضغط هنا لرفع الملفات او قم بسحبها لافلاتها هنا',
		dictRemoveFile:'{{ trans('admin.delete')}}',
		addRemoveLinks:true,
		params:{
			_token:"{{ csrf_token() }}"
		},
		removedfile:function(file){
			$.ajax({
				dataType:'json',
				url:'{{ aurl('delete/image') }}',
				type:'POST',
				data:{_token:'{{ csrf_token() }}' , id:file.id}
			});
			var fmock = file.previewElement;

			return (fmock != null ? fmock.parentNode.removeChild(fmock) : void 0 );

		},
		init:function () {
			@foreach ($product->files as $file)

				var mock = {id:'{{ $file->id }}' , name: '{{ $file->name }}' , size:'{{ $file->size }}' , type:'{{ $file->mime_type }}' };

				this.emit('addedFile' , mock);
				this.addFile.call(this, mock );
				this.options.thumbnail.call(this , mock , '{{Storage::url($file->full_path) }}');

			@endforeach

			this.on('success' , function(file , response){
				if(response){
					file.id = response.id;
				}

			});
		}
	});

	$('#mainphoto').dropzone({
		url:"{{ aurl('update/image/' . $product->id) }}",
		paramName:'file',
		uploadMultiple:false,
		maxFile:1,
		maxFilessize:4,
		acceptedFiles:'image/*',
		dictDefaultMessage:'{{ trans('admin.mainphoto') }}',
		dictRemoveFile:'{{ trans('admin.delete')}}',
		addRemoveLinks:true,
		params:{
			_token:"{{ csrf_token() }}"
		},
		removedfile:function(file){
			$.ajax({
				dataType:'json',
				url:'{{ aurl('delete/product/image/' . $product->id) }}',
				type:'POST',
				data:{_token:'{{ csrf_token() }}'}
			});
			var fmock = file.previewElement;

			return (fmock != null ? fmock.parentNode.removeChild(fmock) : void 0 );

		},
		init:function () {

			@if(!empty($product->photo) )
			var mock = {name: '{{ $product->title }}' , size:'' , type:'' };

			this.emit('addedFile' , mock);
				this.addFile.call(this, mock );
			this.options.thumbnail.call(this , mock , '{{Storage::url($product->photo) }}');
			$('.dz-progress').remove();
			@endif


		}
	});

</script>

<style type="text/css">

	.dz-image img{
		width: 100px;
		height: 100px;
	}

</style>

@endpush

<div id="product_media" class="tab-pane fade">
    <h3>{{ trans('admin.product_media') }}</h3>
    <br>
    <center><h1> {{ trans('admin.mainphoto') }} </h1></center>
    <div class="dropzone" id="mainphoto"></div>
    <br>
    <center><h1> {{ trans('admin.other_files') }} </h1></center>
    <div class="dropzone" id="dropzoneFileUpload"></div>
</div>