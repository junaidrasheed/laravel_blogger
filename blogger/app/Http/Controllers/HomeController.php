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
use App\BlogCategory;
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
    public function index($category = 1)
    {
        $posts = Post::with(['likes','comments'])->where('category_id',$category)->orderby('created_at','desc')->paginate(5);
        $users = User::all();
        $categories  = BlogCategory::with('posts')->get();
        return view('home',compact('posts','users','categories','category'));
    }

    public function create()
    {
        if(Auth::user())
        {
            $categories = BlogCategory::all();
            return view('create',compact('categories'));
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
            $category = $request->input('category');
            //$coverImage = array();

            //dd($request->all());
            $exists = Post::where('slug','=',$slug)->first();
            //if(is_null($postId))
            //{
            if(!is_null($exists))
            {
                return response()->json(['titleError'=>true]);
                //return redirect()->back()->with('titleError','Title Exists Already')->withInput();
            }
            //}
            //dd($request->all());
           
            //$imageFiles = Input::file('covers');
            //d($imageFiles);

            /*foreach($imageFiles as $file)
            {
                
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
                    $file->move($destinationPath,$fileName);
                    array_push($coverImage,$fileName);
                }
            }*/
            
            $newPost = new Post;
            

            //$newPost = new Post;
            $newPost->post = $p;
            $newPost->title= $title;
            $newPost->slug = $slug;
            $newPost->user_id = Auth::user()->id;
            $newPost->category_id = $category;
            $newPost->save();
            /*foreach($coverImage as $c)
            {
                $img = new Image;
                $img->image_path = $c;
                $newPost->image()->save($img);
            }*/
            
            return response()->json(['success'=>true,'postId'=>$newPost->id]);
            //return redirect()->back()->with('success','Blog Created');
        }
        else
        {
            return redirect('login');
        }
    }

    public function addBlogImages(Request $request)
    {
        $newPost = Post::find($request->input('postId'));
        //dd($newPost);
        $coverImage = array();
        $imageFiles = Input::file('covers');
            //d($imageFiles);

        foreach($imageFiles as $file)
        {
            
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
                $file->move($destinationPath,$fileName);
                array_push($coverImage,$fileName);
            }
        }
        foreach($coverImage as $c)
        {
            $img = new Image;
            $img->image_path = $c;
            $newPost->image()->save($img);
        }
        return redirect()->back()->with('success','Blog Created');
    }

    public function saveEditedPost(Request $request)
    {
        if(Auth::user())
        {
            $p = $request->input('post');
            $title = $request->input('title');
            $postId = $request->input('postId');
            $slug = str_slug($title);
           
            $exists = Post::where('slug','=',$slug)->first();
            //if(is_null($postId))
            //{
                if(!is_null($exists) && $postId != $exists->id)
                {
                    return redirect()->back()->with('titleError','Title Exists Already')->withInput();
                }
            //}
   
            $newPost = Post::where('id','=',$postId)->first();
            
            $newPost->post = $p;
            $newPost->title= $title;
            $newPost->slug = $slug;
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

        //dd($post);
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

        $category = BlogCategory::where('id',$post->category_id)->first();
        $categoryname = $category->category;
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
        return view('view',compact('post','username','users','previous','next','categoryname'));
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

    public function getLikesUsers(Request $request)
    {
        //return response()->json("done");
        $pid = $request->input('pid');
        $likes = Like::where('post_id',$pid)->get(['user_id']);
        $users = User::with('image')->whereIn('id',$likes)->get();
        return response()->json($users);
    }

     public function getCommentsUsers(Request $request)
    {
        //return response()->json("done");
        $pid = $request->input('pid');
        $comments = Comment::where('post_id',$pid)->get(['user_id']);
        $users = User::with('image')->whereIn('id',$comments)->get();
        return response()->json($users);
    }

    public function updateBlogImage(Request $request)
    {
        $imageId = $request->input('imageId');
        if(Input::hasFile('newimage'))
        {
            $file = Input::file('newimage');
            //dd($file->getClientOriginalName());
            $input = array('newimage'=>$file);
            $rules = array(
                'newimage'=> 'image|mimes:jpeg,png,jpg,gif|max:10240'
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
                $file->move($destinationPath,$fileName);
                $coverImage = $fileName;

                $img = Image::find($imageId);
                if(!is_null($img))
                {
                    $img->image_path = $coverImage;
                    $img->save();
                    return redirect()->back()->with('imageMsg','Image Updated Successfully');
                }
            }
        }
        else
        {
            return redirect()->back()->with('imageMsg','No image selected');
        }
    }
}
