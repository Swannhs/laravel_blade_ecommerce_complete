<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Notifications\NewAuthorPost;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Modules\Blog\Services\BlogService;
use Illuminate\Support\Facades\Auth;
use Modules\UserActivityLog\Traits\LogActivity;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
        $this->middleware('maintenance_mode');
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        if (!empty($query)) {
         $posts=$this->blogService->postsWithQuery($query);
        }
        else{
        $posts=$this->blogService->getPosts();
        }
        $categoryPost=$this->blogService->categoryPost();
        $popularPost=$this->blogService->popularPost();
        return view('frontend.default.pages.blog.posts',compact(['posts','categoryPost','popularPost']));
    }

    public function singlePage($slug)
    {
        $post=$this->blogService->postWithSlug($slug);
        $blogKey = 'blog_' . $post->id;
        if (!Session::has($blogKey)) {
            $post->increment('view_count');
            Session::put($blogKey,1);
        }
        $posts=$this->blogService->getPosts();
        $categoryPost=$this->blogService->categoryPost();
        $likePost=$this->blogService->likePost($post->id);
        $likecheck=$this->blogService->checkPostLike($post->id);
        $popularPost=$this->blogService->popularPost();
        return view('frontend.default.pages.blog.single_post',compact(['post','posts','categoryPost','likePost','likecheck','popularPost']));

    }
    //comments
    public function commentStore(Request $request, $post_id)
    {

        $request->validate([
            'comment' => 'required',
            ]);
        try{

            $this->blogService->createComment([
                'comment'=>$request['comment'],
                'blog_post_id' => $post_id,
                'user_id' => auth()->user()->id
            ]);
            LogActivity::successLog('comment added.');
            Toastr::success(__('blog.comments_create_successfully'),__('common.success'));
            return redirect()->back();
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }

    }

    //replay to comment

    public function replay(Request $request)
    {

       $request->validate([
            'replay' => 'required'
            ]);
        try{
           $this->blogService->createCommentReplay([
                'replay'=>$request['replay'],
                'blog_post_id' => $request['post_id'],
                'blog_comment_id' => $request['comment_id'],
                'user_id' => auth()->user()->id,
                'replay_id'=>isset($request['replay_id'])?$request['replay_id']:0
            ]);

            LogActivity::successLog('reply added');
            Toastr::success(__('blog.replay_create_successfully'),__('common.success'));
            return redirect()->back();
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }

    //category wise post
    public function catgoryPost($slug)
    {
         $categoryPosts=$this->blogService->categoryPostWithId($slug);
         $posts=$this->blogService->getPosts();
         $categoryPost=$this->blogService->categoryPost();
         $popularPost=$this->blogService->popularPost();
         return view('frontend.default.pages.blog.category_post',compact(['categoryPosts','categoryPost','posts','popularPost']));
    }



    //like
    public function like(Request $request){

        $likeCheck=$this->blogService->checkPostLike($request->pid);
        if ($likeCheck) {
            $this->blogService->deletePostLike($likeCheck->id);
            return response()->json([
            'dislike' => 'You dislike the post'
            ]);
        }
        else{
            $this->blogService->createPostLike([
                'user_id'=>Auth::id(),
                'post_id'=>$request->pid,
                'like'   =>true
            ]);
            return response()->json([
            'like' => 'You like the post'
            ]);
        }

    }

    public function search(Request $request){
        return response()->json([
            'data'=>$request->all()
        ]);
    }
}
