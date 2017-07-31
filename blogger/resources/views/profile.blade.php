@extends('layouts.blog')

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
			@if(session()->has('successMsg'))
				<div class="alert alert-success">
					{{ session('successMsg') }}
				</div>
			@endif
			<h3>Select an image:</h3>
			
			<form action="updateUserImage" method="POST" enctype="multipart/form-data">
				<input type="hidden" value="{{csrf_token()}}" name="_token">
				<input type="hidden" value="{{Auth::user()->id}}" name="userId">
				<input type="file" id="profileImage" required name="selectedImage" onchange="readURL(this)"><br>
				<img src="" id="selectedImage" alt="New Image"  style="width:150px;height:150px"><br><br>
				@if(session()->has('imageError'))
				<span style="color:red"> {{ session('imageError')}}</span>
				@endif
				<button id="updateImage" class="btn btn-sm btn-primary">Update Image</button>
			</form>
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

</script>
@endsection