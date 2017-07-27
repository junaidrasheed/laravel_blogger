@extends ('layouts.blog')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			@if(session()->has('success'))
				<div class="alert alert-success">
					Blog Updated Successfully.!
				</div>
			@endif
			<div class="panel panel-warning">
	            <div class="panel-heading">Edit Your Blog Here</div>
	            <div class="panel-body">
	                <form action='saveEditPost' method="POST" enctype="multipart/form-data">
	                    <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
	                    <input type="hidden" name="postId" value="{{$post->id}}">
	                    <input type="text" class="form-control" maxlength="5000" name="title" required  value="@if(old('title')) {{old('title') }} @else {{ $post->title }} @endif" placeholder="Blog Title">
	                    @if(session()->has('titleError')) <span style="color:red"> {{ session('titleError')}} </span> @endif <br>
	                    <textarea rows="10" placeholder="Write Here.." required class="form-control" oninput="enableButton($.trim(this.value))" style="resize:vertical" maxlength="10000" name="post">@if(old('post')) {{ old('post')}} @else {{ $post->post }} @endif</textarea><br>
	                    <div style="width:50%;float:left">
		                    <input type="file" name="cover" onchange="readURL(this);$('#btnSubmit').prop('disabled',false)">
		                    <img id="selectedImage" src="" style="width:150px;height:150px" alt="Cover Image"><br>
		                    @if(session()->has('imageError'))
		                    	<span style="color:red">{{ session('imageError') }}</span>
		                    @endif
	                    </div>
	                    <div style="width:50%;float:right">
	                    	<span> Current Image: </span>
	                    	<img src="{{URL::asset('images/'.$post->image)}}" style="width:150px;height:150px">
	                    </div>
	                    <div style="clear:both"></div>
	                    <div style="margin-top:20px;">
	                        <button type="submit" id="btnSubmit" class="btn btn-sm btn-primary">Update</button>
	                    </div>    
	                </form>
	                
	            </div>
	        </div>
		</div>
	</div>
	
</div>

@endsection

@section('customScript')
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<script type="text/javascript">
	function readURL(input){
		if(input.files && input.files[0]){
			var reader = new FileReader();

			reader.onload = function (e){
				$('#selectedImage').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	function enableButton(obj)
    {
        if(obj.length == 0)
        {
            $('#btnSubmit').prop('disabled',true);
        }
        else
            $('#btnSubmit').prop('disabled',false);

    }


	
</script>

@endsection