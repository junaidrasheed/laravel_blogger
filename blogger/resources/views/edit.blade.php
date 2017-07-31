@extends ('layouts.blog')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-2" id="profileImage">
            <a href="{{url('profile')}}">
                <div style="height:200px" title="Click to update profile image">
                    <img src="@if(is_null(Auth::user()->Image)) {{ URL::asset('images/profile.png')}} @else {{ URL::asset('images/'.Auth::user()->Image->image_path) }} @endif" alt="Profile Image" style="width:100%;height:100%" class="img img-thumbnail">
                </div>
            </a>
            <h4 style="text-align:center">Hi, 
            <?php 
                $name = explode(" ",Auth::user()->name);
                echo $name[0]; 
            ?></h4>
        </div>
		<div class="col-md-10">
			@if(session()->has('success'))
				<div class="alert alert-success">
					Blog Updated Successfully.! <a href="{{ url('view/'. $post->slug)}}">View</a>
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
	                   
	                    
	                    <div style="margin-top:20px;">
	                        <button type="submit" id="btnSubmit" class="btn btn-sm btn-primary">Update</button>
	                    </div>    
	                </form>
	                <br>
	                <div>
	                	@if(session()->has('imageMsg'))
	                		<div class="alert alert-success">
	                			{{ session('imageMsg')}}
	                		</div>
	                	@endif
                    	<span> Current Images: </span>
                    	@foreach($post->image as $img)
                    	<form action="updateBlogImage" method="POST" enctype="multipart/form-data">
                    		<input type="file" value="Change" onchange="$(this).closest('form').submit();" name="newimage">
                    		<input type="hidden" name="_token" value="{{csrf_token()}}">
                    		<input type="hidden" name="imageId" value="{{$img->id}}">
							<img src=" {{ URL::asset('images/'.$img->image_path)}}" alt="Cover Image" title="{{$img->image_path}}" style="width:100px;height:100px">
						</form><br>
						@endforeach
                    	
                    </div>
	                
	            </div>
	        </div>
		</div>
	</div>
	
</div>

@endsection

@section('customScript')

<script type="text/javascript">

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