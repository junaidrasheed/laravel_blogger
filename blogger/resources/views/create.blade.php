@extends ('layouts.blog')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			@if(session()->has('success'))
				<div class="alert alert-success">
					Blog Posted Successfully.!
				</div>
			@endif
			<div class="panel panel-warning">
	            <div class="panel-heading">What's on your mind?</div>
	            <div class="panel-body">
	                <form action='addPost' method="POST" id="blogPost" enctype="multipart/form-data">
	                    <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
	                    <input type="text" class="form-control" maxlength="5000" name="title" required  value="@if(old('title')) {{old('title')}} @endif" placeholder="Write Blog Title Here..">
	                    @if(session()->has('titleError')) <span style="color:red"> {{ session('titleError')}} </span> @endif <br>
	                    <textarea rows="10" placeholder="Write Your Blog Here.." required  class="form-control" oninput="enableButton($.trim(this.value))" style="resize:vertical" maxlength="10000" id="post" name="post">@if(old('post')) {{ old('post')}} @endif</textarea><br>
	                    <input type="file" name="cover" required onchange="readURL(this);$('#btnSubmit').prop('disabled',false)">
	                    
	                    <img id="selectedImage" src="" style="width:150px;height:150px" alt="Cover Image"><br>
	                    @if(session()->has('imageError'))
	                    	<span style="color:red">{{ session('imageError') }}</span>
	                    @endif
	                    <div style="margin-top:20px;">
	                        <button type="submit" id="btnSubmit" class="btn btn-sm btn-primary">Post Your Blog</button>
	                    </div>    
	                </form>
	                
	            </div>
	        </div>
		</div>
	</div>
	
</div>

@endsection

@section('customScript')

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