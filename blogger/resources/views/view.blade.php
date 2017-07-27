@extends('layouts.blog')


@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
		<div class="panel">	
			<div class="panel-body">
				<input type="hidden" id="token" name="token" value="{{csrf_token()}}">
				<input type="hidden" id="postId" value="{{$post->id}}">
				<input type="hidden" id="userId" value="{{Auth::user()->id}}">
				<div>
					<h1>{{ $post->title }}</h1>
					<span style="font-size:11px">{{Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</span>
                    <h5>By:
                    <b>
                        {{$username}}
                    </b>
                    </h5>
				</div>
				<div style="border-top:1px solid #efefef;margin:10px">
					<div class="blog" style="margin-bottom:30px">
						{{ $post->post }}
					</div>
					<div class="img">
						<img src=" {{ URL::asset('images/'.$post->image)}}" alt="Cover Image" title="Cover Image" style="width:100%;height:200px">
					</div>
				</div>
				<div style="border-top:1px solid #efefef;border-bottom:1px solid #efefef;padding:10px">
					<div id="likeDiv" style="float:left;margin-right:20px;border-radius:5px">
						<span class="likeCount">{{ $post->likes->count()}}</span>
						<label style="cursor:pointer" id="likeBtn">Likes</label>
						@foreach($post->likes as $l)
							@if($l->user_id == Auth::user()->id)
							<script type="text/javascript">
								$('#likeDiv').css('color','#3097D1');
							</script>
							@endif
						@endforeach
					</div>
					<div style="float:left">
						<span class="commentCount">{{ $post->comments->count() }}</span>
						<label style="cursor:pointer" for="addComment">Comments</label> 
 					</div>
 					<div style="clear:both"></div>
				</div>
				<div>
					<div style="width:90%;float:left">
						<input type="text" class="form-control" id="addComment" style="padding:10px" maxlenght="10000" name="addComment" placeholder="Add Comment">	
					</div>
					<div style="width:8%;float:right">
						<button id="btnAddCommnet" class="btn btn-success" title="Send Your Comment">Send</button>						
					</div>
					<div style="clear:both"></div>
				</div>
				<div class="userComments" style="padding:10px">
					
					@foreach($post->comments as $c)
						@foreach($users as $u)
							
							@if($u->id == $c->user_id)
							<div class="panel-body" style="background-color:#efefef;margin-bottom:5px;border-radius:5px">
								<div>
									<h5 style="margin:0;margin-bottom:5px"><b>{{ $u->name }}</b></h5>
								</div>
								<div >
									{{ $c->comment }}
								</div>
								<div>
									<span style="font-size:11px">{{ Carbon\Carbon::parse($c->created_at)->diffForHumans()}}</span>
								</div>
							</div>
							@endif
						@endforeach
					@endforeach

				</div>
			</div>
		</div>

		<div class="panel">
			<div class="panel-body">
				<div style="float:left">
					<span style="font-size:'13px"> << Previous </span><br>
					<a  href="@if(is_null($previous)) # @else {{ URL::to('view/'.$previous->slug)}} @endif" title="Go to Previous Blog"> @if(!is_null($previous)){{ $previous->title}} @endif</a>

				</div>
				<div style="float:right">
				<span style="font-size:'13px"> Next >> </span><br>
					<a  href="@if(is_null($next)) # @else {{ URL::to('view/'.$next->slug)}} @endif" title="Go to Next Blog" >@if(!is_null($next)){{ $next->title}} @endif</a>
				</div>
			</div>
		</div>

		</div>
	</div>
</div>

@endsection

@section('customScript')
<script type="text/javascript">
	$(document).ready(function(){
		$('#btnAddCommnet').click(function(){

			var comm = $.trim($('#addComment').val());
			if(comm == '')
			{
				$('#addComment').css('border','1px solid red');
			}
			else
			{
				var data = {
					_token: $('#token').val(),
					postId: $('#postId').val(),
					userId: $('#userId').val(),
					comment : comm
				};

				var settings ={
					url: 'addComment',
					data: data,
					datatype: 'JSON',
					type: 'POST',
					success:function(e)
					{
						window.location.reload();;
					},
					error:function()
					{
						alert("Failed to add comment.");
					}
				};
				$.ajax(settings);
			}

		});

		$('#likeBtn').click(function(){
			var data= {
				_token : $('#token').val(),
				postId : $('#postId').val(),
				userId  : $('#userId').val()
			};

			var settings={
				url: 'addLike',
				data: data,
				datatype:'JSON',
				type: 'POST',
				success:function(e)
				{
					window.location.reload();
				},
				error:function()
				{
					alert("Failed to like the post");
				}
			};
			$.ajax(settings);
		});

	});
</script>
@endsection