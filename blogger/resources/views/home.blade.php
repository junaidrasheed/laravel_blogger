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
            ?>
                
            </h4>
        </div>
        <div class="col-md-10">

        @if(Auth::user())
        <div style="padding-bottom:10px">
            <a href="{{ url('create-blog') }}" style="float:right"><button class="btn btn-primary" title="Create a new blog">Create Your Blog</button></a>
             
            <div style="clear:both"></div>

        </div>
        @endif

        <div class='panel panel-default' style="padding:10px">
            
            <div>
            <span style="margin-right:10px"><b>Categories:</b></span>
            @foreach($categories as $c)
                @if($c->id == $category) <b> @endif
                <span class='badge'>{{ $c->posts()->count()}}</span>
                <a style="margin-right:20px" href="{{url('home/'.$c->id)}}">{{ $c->category }}</a>
                @if($c->id == $category) </b> @endif
            @endforeach
            </div>
        </div>
        <h1>Recent Updates</h1>
        @foreach($posts as $p)
             <div class="panel panel-default">
                <div class="panel-heading">
                    @if(Auth::user()->id == $p->user_id)
                    <div style="float:right">
                        <a href="{{ url('edit/'.$p->slug ) }} "><button class="btnPostEdit btn btn-sm btn-default" value="{{$p->id}}" title="Edit This Blog"><span class="glyphicon glyphicon-pencil"></span></button></a>
                        <button class="btnPostDelete btn btn-sm btn-danger" value="{{$p->id}}" title="Delete This Blog"><span class="glyphicon glyphicon-trash"></span></button>
                    </div>
                    @endif
                   <h3> <a href=" {{ url('view/'.$p->slug )}}">{{ $p->title }}</a> </h3>
                   
                    <span style="font-size:11px">{{Carbon\Carbon::parse($p->created_at)->diffForHumans()}}</span>
                    <h5>By:
                    <b>
                        @foreach($users as $u)
                            @if($u->id == $p->user_id)
                            {{$u->name}}
                            @endif
                        @endforeach
                    </b>
                    </h5>
                    
                    <div style="clear:both"></div>
                </div>
           
                <div class="panel-body">
                    <div class="blogText" style="padding-top:10px;padding-bottom:10px">
                        <span class="userPost">{!! $p->post !!}</span>
                    </div>
                </div>
                
                <div style="border-top:1px solid #efefef">
                    <div class="likes" style="float:left;padding:10px">
                       <span class="counts likes" data="{{$p->id}}" title="{{$p->likes->count() }} people have liked this"> {{ $p->likes->count()}} Likes</span>
                    </div>
                    <div class="comments" style="float:left;padding:10px">
                        <span class="counts comments" data="{{$p->id}}" title="{{$p->likes->count() }} people have commented on this"> {{ $p->comments->count()}} Comments</span>
                    </div>
                    <div style="clear:both"></div>
                </div>
             </div>
        @endforeach

            {{ $posts->render() }}           
        </div>
    </div>


    <div style="display:none">
        <div id="layoverLikesDiv" title='People who liked this' style="height:400px;overflow-y:auto;">
            <!--<div style="float:left;width:30px;height:30px">
                <img src="" alt="usericon" style="width:100%;height:100%">
            </div>
            <div style="float:left;padding-top:5px;padding-left:5px">
                <span class="username">Junaid</span>
            </div>
            <div style="clear:both"></div>-->
        </div>
        <div id="layoverCommentsDiv" title="People who commented on this"></div>
    </div>
</div>
@endsection

@section('customScript')

<script type="text/javascript">
    
    $(document).ready(function(){
        

        $('#layoverLikesDiv').dialog({
            autoOpen:false,
            width:400,
            height:400,
            modal:true
        });
        $('#layoverCommentsDiv').dialog({
            autoOpen:false,
            width:400,
            height:400,
            modal:true
        });

        $(document).on('click','.btnPostDelete',function(){
            var id=$(this).attr('value');
            var c = confirm('Are You Sure?');
            if(c>0)
            {
                var data = {
                    _token: $('#token').val(),
                    postId: id
                };

                var settings = {
                    data: data,
                    url: 'deletePost',
                    datatype:'JSON',
                    type: 'POST',
                    success:function(){
                        alert("Post Deleted Successfully");
                        window.location.reload();
                    },
                    error:function(){
                        alert("Could Not Delete Post. Try Again Later");
                    }
                };
                $.ajax(settings);
            }
        });

        $('div.blogText').text(function(){
            var text = $(this).find('span').text();
            return text.substr(0,100) + '...';
        });
       
       $('span.likes').css('cursor','pointer');
       $('span.comments').css('cursor','pointer');

       $('span.likes').click(function(){
            var data={
                _token:$('#token').val(),
                pid: $(this).attr('data')
            };
            //alert(JSON.stringify(data));

            var settings={
                url:'../getLikesUsers',
                datatype: 'JSON',
                data:data,
                type: 'POST',
                success:function(e){
                    var html='';
                    for(var i=0;i< e.length ;i++)
                    {
                        html = html + '<div><div style="float:left;width:30px;height:30px"><img src="../images/'+e[i].image.image_path+'" alt="usericon" style="width:100%;height:100%"></div><div style="float:left;padding-top:5px;padding-left:5px"><span class="username">'+e[i].name+'</span></div><div style="clear:both"></div><hr style="margin:5px"></div>';
                    }
                    $('#layoverLikesDiv').html(html);
                    $('#layoverLikesDiv').dialog('open');
                },
                error:function()
                {
                    alert("Could not load data");
                }
            };

            $.ajax(settings);
       });

       $('span.comments').click(function(){
            var data={
                _token:$('#token').val(),
                pid: $(this).attr('data')
            };
            //alert(JSON.stringify(data));

            var settings={
                url:'../getCommentsUsers',
                datatype: 'JSON',
                data:data,
                type: 'POST',
                success:function(e){
                    var html='';
                    for(var i=0;i< e.length ;i++)
                    {
                        html = html + '<div><div style="float:left;width:30px;height:30px;"><img src="../images/'+e[i].image.image_path+'" alt="usericon" style="width:100%;height:100%"></div><div style="float:left;padding-top:5px;padding-left:5px"><span class="username">'+e[i].name+'</span></div><div style="clear:both"></div><hr style="margin:5px"></div>';
                    }
                    $('#layoverCommentsDiv').html(html);
                    $('#layoverCommentsDiv').dialog('open');
                },
                error:function()
                {
                    alert("Could not load data");
                }
            };

            $.ajax(settings);
       });

    });
    
</script>
@endsection