@extends('layouts.blog')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

        @if(Auth::user())
        <div style="padding-bottom:10px">
            <a href="create-blog" style="float:right"><button class="btn btn-primary" title="Create a new blog">Create Your Blog</button></a>
            <div style="clear:both"></div>
        </div>
        @endif


        <h1>Recent Updates</h1>
        @foreach($posts as $p)
             <div class="panel panel-default">
                <div class="panel-heading">
                    @if(Auth::user()->id == $p->user_id)
                    <div style="float:right">
                        <a href="edit/{{ $p->slug}}"><button class="btnPostEdit btn btn-sm btn-default" value="{{$p->id}}" title="Edit This Blog"><span class="glyphicon glyphicon-pencil"></span></button></a>
                        <button class="btnPostDelete btn btn-sm btn-danger" value="{{$p->id}}" title="Delete This Blog"><span class="glyphicon glyphicon-trash"></span></button>
                    </div>
                    @endif
                   <h3> <a href="view/{{ $p->slug}} ">{{ $p->title }}</a> </h3>
                   
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
                       <span class="counts"> {{ $p->likes->count()}} Likes</span>
                    </div>
                    <div class="comments" style="float:left;padding:10px">
                        <span class="counts"> {{ $p->comments->count()}} Comments</span>
                    </div>
                    <div style="clear:both"></div>
                </div>
             </div>
        @endforeach

            {{ $posts->render() }}           
        </div>
    </div>
</div>
@endsection

@section('customScript')

<script type="text/javascript">
    
    $(document).ready(function(){
        
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
       

    });
    
</script>
@endsection