<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Post;
use App\Follower;
use App\Like;
use App\Comment;
use App\User;
use Validator;
use App\Image;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['likes','comments'])->orderby('created_at','desc')->paginate(5);
        $users = User::all();
        return view('home',compact('posts','users'));
    }

    public function create()
    {
        if(Auth::user())
        {
            return view('create');
        }
        else
        {
            return "<h1>You Do Not Have Sufficient Permission To Create New Blog</h1>";
        }
    }

    public function addPost(Request $request)
    {
        if(Auth::user())
        {
            $p = $request->input('post');
            $title = $request->input('title');
            $slug = str_slug($title);
            $coverImage = NULL;

            //dd($request->all());
            $exists = Post::where('slug','=',$slug)->first();
            //if(is_null($postId))
            //{
                if(!is_null($exists))
                {
                    return redirect()->back()->with('titleError','Title Exists Already')->withInput();
                }
            //}
            //dd($request->all());
           
            if(Input::hasFile('cover'))
            {
                $file = Input::file('cover');
                //dd($file->getClientOriginalName());
                $input = array('cover'=>$file);
                $rules = array(
                    'cover'=> 'image|mimes:jpeg,png,jpg,gif|max:10240'
                    );

                $validator = Validator::make($input,$rules);
                if($validator->fails())
                {
                    return redirect()->back()->with('imageError','Invalid Image');
                }
                else
                {
                    $destinationPath = 'images/';
                    $fileName = $file->getClientOriginalName();
                    Input::file('cover')->move($destinationPath,$fileName);
                    $coverImage = $fileName;
                }
            }
            
            $newPost = new Post;
            $img = new Image;

            //$newPost = new Post;
            $newPost->post = $p;
            $newPost->title= $title;
            $newPost->slug = $slug;
            $newPost->user_id = Auth::user()->id;
            $newPost->save();
            $newPost->image()->save($img);
            return redirect()->back()->with('success','Blog Created');
        }
        else
        {
            return redirect('login');
        }
    }


    public function saveEditedPost(Request $request)
    {
        if(Auth::user())
        {
            $p = $request->input('post');
            $title = $request->input('title');
            $postId = $request->input('postId');
            $slug = str_slug($title);
            $coverImage = NULL;

            //dd($request->all());
            $exists = Post::where('slug','=',$slug)->first();
            //if(is_null($postId))
            //{
                if(!is_null($exists) && $postId != $exists->id)
                {
                    return redirect()->back()->with('titleError','Title Exists Already')->withInput();
                }
            //}
            //dd($request->all());
           
            if(Input::hasFile('cover'))
            {
                $file = Input::file('cover');
                //dd($file->getClientOriginalName());
                $input = array('cover'=>$file);
                $rules = array(
                    'cover'=> 'image|mimes:jpeg,png,jpg,gif|max:10240'
                    );

                $validator = Validator::make($input,$rules);
                if($validator->fails())
                {
                    return redirect()->back()->with('imageError','Invalid Image');
                }
                else
                {
                    $destinationPath = 'images/';
                    $fileName = $file->getClientOriginalName();
                    Input::file('cover')->move($destinationPath,$fileName);
                    $coverImage = $fileName;
                }
            }
            
            $newPost = Post::with('image')->where('id','=',$postId)->first();

            if($coverImage != NULL)        //case of editing and image updated
            {
                $img = $newPost->Image;
                if(is_null($img))
                    $img = new Image;
                $img->image_path = $coverImage;
                $newPost->image()->save($img);
            }
            //$newPost = new Post;
            $newPost->post = $p;
            $newPost->title= $title;
            $newPost->slug = $slug;
            $newPost->user_id = Auth::user()->id;
            $newPost->save();
            
            return redirect()->back()->with('success','Blog Created');
        }
        else
        {
            return redirect('login');
        }
    }

    public function deletePost(Request $request)
    {
        if(Auth::user())
        {
            $id = $request->input('postId');
            $post = Post::find($id);
            if(!is_null($post))
            {
                $post->delete();
            }
            return response()->json("done");
        }
        else
        {
            return redirect('login');
        }
    }

    public function editPost(Request $request)
    {
        if(Auth::user())
        {
            $id = $request->input('postId');
            $text = $request->input('post');
            $post = Post::with('image')->first();
            if(!is_null($post))
            {
                $post->post = $text;
                $post->save();
            }

            return redirect()->back();
        }
        else
        {
            return redirect('login');
        }
    }

    public function viewBlog($slug)
    {
        $post = Post::with(['likes','comments','image'])->where('slug','=',$slug)->first();

        if(is_null($post))
        {
            return response("<div class='panel' style='margin:auto;width:300px'><b>Post Not Found</b></div>");
        }

        
        $uids = array();
        //dd($post->comments);
        foreach($post->comments as $c)
        {
            $u = User::find($c->user_id);
            array_push($uids, $u->id);
        }

        $nxt = Post::where('id','<',$post->id)->max('id');
        $next = Post::find($nxt);
        $pre = Post::where('id','>',$post->id)->min('id');
        $previous = Post::find($pre);
        $users = User::whereIn('id',$uids)->with('image')->get();

        //dd($previous .' ' .$next);
        //dd($users);
        $u = User::find($post->user_id);
        $username = $u->name;
        //dd($post);
        return view('view',compact('post','username','users','previous','next'));
    }

    public function addComment(Request $request)
    {
        $comm = $request->input('comment');
        $userId = $request->input('userId');
        $postId = $request->input('postId');

        $comment = new Comment;
        $comment->comment = $comm;
        $comment->user_id = $userId;
        $comment->post_id = $postId;

        $comment->save();
        return response()->json('done');
    }

    public function addLike(Request $request)
    {
        
        $userId = $request->input('userId');
        $postId = $request->input('postId');

        $like = Like::where([['user_id',$userId],['post_id',$postId]])->first();
        if(is_null($like))
            $like = new Like;
        $like->user_id = $userId;
        $like->post_id = $postId;

        $like->save();
        return response()->json('done');
    }

    public function edit($slug)
    {
        $post = Post::where('slug','=',$slug)->first();
        if(is_null($post))
        {
            return response("<div style='margin:auto;width:300px'><b>Post Not Found</b></div>");
        }
        else
            return view('edit',compact('post'));
    }

    public function profileImage()
    {
        return view('profile');
    }

    public function updateProfileImage(Request $request)
    {
        $userId = $request->input('userId');
        $selectedImage = NULL;
        if(Input::hasFile('selectedImage'))
        {
            $file = Input::file('selectedImage');
            //dd($file->getClientOriginalName());
            $input = array('userimage'=>$file);
            $rules = array(
                'userimage'=> 'image|mimes:jpeg,png,jpg,gif|max:10240'
                );

            $validator = Validator::make($input,$rules);
            if($validator->fails())
            {
                return redirect()->back()->with('imageError','Invalid Image');
            }
            else
            {
                $destinationPath = 'images/';
                $fileName = $file->getClientOriginalName();
                Input::file('selectedImage')->move($destinationPath,$fileName);
                $selectedImage = $fileName;
            }
        }
        $user = User::with('image')->where('id','=',$userId)->first();
        if(is_null($user->Image))
        {
            $img = new Image;
            $img->image_path = $selectedImage;
            $user->image()->save($img);
            return redirect()->back()->with('successMsg','Image Updated Successfully.!');
        }
        else
        {
            $img = $user->Image;
            $img->image_path = $selectedImage;
            $user->image()->save($img);
            return redirect()->back()->with('successMsg','Image Updated Successfully.!');
        }
      
    }
}
