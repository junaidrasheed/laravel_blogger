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
            ?>
            </h4>
        </div>
		<div class="col-md-10">

			@if(session()->has('success'))
				<div class="alert alert-success" id="succesMsg">
					Blog Posted Successfully.! <a href="{{ url('home')}}">View</a>
				</div>
			@endif
			
			<div class="panel panel-warning">
	            <div class="panel-heading">What's on your mind?</div>
	            <div class="panel-body">
	                <!--<form action='addPost' method="POST" id="blogPost" enctype="multipart/form-data">-->
	                   
	                    
	                    <label for="title">Blog Title: </label>
	                    <input type="text" class="form-control" maxlength="5000" id="title" name="title" oninput="countTitleLetters(this.value)" required  value="@if(old('title')) {{old('title')}} @endif" placeholder="Write Blog Title Here..">
	                    <div style="float:right">
	                    	<span id='titleRemainingLetters' style="font-size:9px">0</span><span style="font-size:9px">/1000</span>
	                    </div>
	                    <span style="color:red;display:none" id="titleError"> Title Exists Already </span> <br>
	                    
	                    <div id="postTextarea">
	                    <label for="post">Blog Description:</label>
	                    <textarea rows="10" placeholder="Write Your Blog Here.." required  class="form-control" oninput="countBlogLetters(this.value);enableButton($.trim(this.value))" style="resize:vertical" maxlength="10000" id="post" name="post">@if(old('post')) {{ old('post')}} @endif</textarea>
	                    <div style="float:right">
	                    	<span id='blogRemainingLetters' style="font-size:9px">0</span><span style="font-size:9px">/10000</span>
	                    </div>
	                    </div>
	                    <br>

	                    <label for="category" >Blog Category:</label>
	                    <select name="category" id="category" class='form-control'>
	                    	<option value='null'>--Select--</option>
	                    	@foreach($categories as $c)
	                    	<option value='{{ $c->id }}'>{{ $c->category }}</option>
	                    	@endforeach
	                    </select>
	                    
	                       
	               <!-- </form> -->
	               	<br>
	                <div>
	                	<form action="postBlogImages" method="POST" id="imagesForm" enctype="multipart/form-data">
	                		<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
	                		<input type="hidden" id="postId" name="postId" value="">
	                		<input type="hidden" id="imagesSelected" name="imagesSelected" value="no">
	                		<label for="covers[]">Attach Images: </label>
			                <input type="file" name="covers[]" required multiple id="files" onchange="$('#btnSubmit').prop('disabled',false)">
		                    <div id="result">
		                    	<span>Selected Images:</span>
		                    </div>
		                    <div style="clear:both"></div>
		                   
		                    @if(session()->has('imageError'))
		                    	<span style="color:red">{{ session('imageError') }}</span>
		                    @endif
	                    </form>
	                </div>

	                <div style="margin-top:20px;">
                        <button type="submit" id="btnSubmit" class="btn btn-sm btn-primary" title="Post Your Blog">Post Your Blog</button>
                    </div> 
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

	window.onload = function(){
	    //Check File API support
	    if(window.File && window.FileList && window.FileReader)
	    {
	        var filesInput = document.getElementById('files');
	        filesInput.addEventListener('change', function(event){
	            var files = event.target.files; //FileList object
	            var output = document.getElementById("result");
	            for(var i = 0; i< files.length; i++)
	            {
	                var file = files[i];
	                //Only pics
	                if(!file.type.match("image"))
	                    continue;
	                var picReader = new FileReader();
	                picReader.addEventListener('load',function(event){
	                    var picFile = event.target;
	                    var div = document.createElement("div");
	                    div.innerHTML = "<img class='img img-thumbnail' style='width:100px;height:100px;float:left' src='" + picFile.result + "' " + "title='" + picFile.name + "'/>";
	                    output.insertBefore(div,null);
	                });
	                //Read the image
	                picReader.readAsDataURL(file);
	            }

	            $('#imagesSelected').val('yes');
	        });
	    }
	    else
	    {
	        console.log('Your browser does not support File API');
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

    function countTitleLetters(object, t)
    {
    	$('#titleRemainingLetters').text(object.length);
    }

    function countBlogLetters(object, t)
    {
    	$('#blogRemainingLetters').text(object.length);
    }


    $(document).ready(function(){
    	$('#btnSubmit').click(function(){
    		var post = new $('#postTextarea').find('.nicEdit-main').html();
    		var title = $.trim($('#title').val());
    		var category = $('#category').val();
    		var images = $('#imagesSelected').val();
    		var flag = false;

    		//alert(category);

    		if(post == '')
    		{
    			$('#post').addClass('error');
    			flag  = true;
    		}
    		if(title == '')
    		{
    			$('#title').addClass('error');
    			flag = true;
    		}

    		if(category == 'null')
    		{
    			$('#category').addClass('error');
    			flag = true;
    		}

    		if(images == 'no')
    		{
    			$('#files').addClass('error');
    			flag  = true;
    		}

    		if(!flag)
    		{
    			var data = {
    				_token : $('#token').val(),
    				post : post,
    				title: title,
    				category: category
    			};

    			var settings = {
    				url: 'addPost',
    				datatype: 'JSON',
    				type: 'POST',
    				data: data,
    				success:function(e){
    					//alert(JSON.stringify(e));
    					
    					if(e.success)
    					{
    						$('#postId').val(e.postId);
    						$('#imagesForm').submit();
    					}
    					if(e.titleError)
    					{
    						$('#titleError').show();
    					}
    				},
    				error: function()
    				{
    					alert("Failed to post your blog");
    				}
    			};
    			$.ajax(settings);
    		}	

    	});
    });
	

	
</script>

@endsection