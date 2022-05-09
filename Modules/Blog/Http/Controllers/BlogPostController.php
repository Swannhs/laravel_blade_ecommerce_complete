<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Http\Requests\BlogPostRequest;
use Modules\Blog\Http\Requests\BlogPostUpdateRequest;
use Modules\Blog\Services\BlogPostService;
use Modules\Blog\Entities\BlogTag;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Traits\ImageStore;
use App\Notifications\NewAuthorPost;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Exception;
use Intervention\Image\Facades\Image;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Setup\Entities\Tag;
use Modules\Setup\Repositories\TagRepository;
use Modules\UserActivityLog\Traits\LogActivity;
use Yajra\DataTables\Facades\DataTables;

class BlogPostController extends Controller
{
    use ImageStore;
    protected $blogPostService;

    public function __construct(BlogPostService $blogPostService)
    {
        $this->blogPostService = $blogPostService;
        $this->middleware('maintenance_mode');
        $this->middleware('prohibited_demo_mode')->only('store','update','destroy');
    }

    public function index()
    {
        $data['CategoryList']=$this->blogPostService->categoryList();
        $data['TagList']=$this->blogPostService->tagList();
        if (auth()->user()->role->type == 'superadmin') {
            $data['PostList']=$this->blogPostService->getAll();
        }
        else{
            $data['PostList']=$this->blogPostService->getUserPost();
        }

        return view('blog::post.index',$data);
    }

    public function getData(){

        if (auth()->user()->role->type == 'superadmin') {
            $value = $this->blogPostService->getAll();
        }
        else{
            $value = $this->blogPostService->getUserPost();
        }

        return DataTables::of($value)
            ->addIndexColumn()
            ->addColumn('title', function($value){
                return Str::limit($value->title,15);
            })
            ->addColumn('author', function($value){
                return $value->user->getFullNameAttribute();
            })
            ->addColumn('approved', function($value){
                return view('blog::post.components._approve_td',compact('value'));
            })

            ->addColumn('status', function($value){
                return view('blog::post.components._status_td',compact('value'));
            })
            ->addColumn('published_at', function($value){
                return \Carbon\Carbon::parse($value->published_at)->toDayDateTimeString();
            })
            ->addColumn('action', function($value){
                return view('blog::post.components._action_td',compact('value'));
            })
            ->rawColumns(['approved','status','action'])
            ->toJson();
    }


    public function create()
    {
        $data['CategoryList']=$this->blogPostService->categoryParentList();
        $data['TagList']=$this->blogPostService->tagList();
        return view('blog::post.create',$data);
    }


    public function store(BlogPostRequest $request)
    {
        DB::beginTransaction();
        
        try{
            $file = $request->file('file');
            if($request->hasFile('file'))
            {
                $filename=$this->saveImage($file,1000,500);
            }
            $post = $this->blogPostService->create([
                'author_id'  => Auth::id(),
                'title'      => $request['title'],
                'slug'       => $request['slug'],
                'content'    => $request['content'],
                'image_url'  => isset($filename)? $filename : null,
                'status'     => isset($request->status)? true: false,
                'is_commentable' =>isset($request->comments) ? false:true,
                'published_at' => Carbon::now()
            ]);

            $tags = explode(',', $request->tag);

            $sync_array = [];

            foreach ($tags as $tag) {

                if($tag != '' && preg_match("/^[a-z0-9 .\-]+$/i", $tag)){

                    $is_tag = (new TagRepository())->is_tag($tag);

                    if ($is_tag) {

                        array_push($sync_array, $is_tag->id);
                    } else {
                        $tags = new Tag();
                        $tags->name = trim(strtolower($tag));
                        $tags->save();
                        array_push($sync_array, $tags->id);
                    }
                }
            }

            $post->tags()->sync($sync_array);
            $post->categories()->attach($request->categories);


            $admins=User::whereIn('role_id',[1,2,3])->get();
            $details['body']= auth()->user()->fullname.'Has Created a New Post';
            Notification::send($admins, new NewAuthorPost($details));
            DB::commit();
            Toastr::success(__('common.operation_done_successfully'),__('common.success'));
            LogActivity::successLog('blog post added.');
            return redirect()->route('blog.posts.index');
             
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }


    public function show($id)
    {
        $data=$this->blogPostService->findWithRelModal($id);
        return view('blog::post.show',compact('data'));
    }


    public function edit($id)
    {
         $data['post']=$this->blogPostService->findWithRelModal($id);
        $data['cat_id']=[];
        foreach ($data['post']->categories as $value) {
            array_push($data['cat_id'], $value->id);
        }
         $data['CategoryList']=$this->blogPostService->categoryParentList();

        $data['TagList']=$this->blogPostService->tagList();
        return view('blog::post.edit',$data);
    }


    public function update(BlogPostUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try{

            if($request->hasFile('file'))
            {   $post=$this->blogPostService->find($id);
                if(file_exists($post->image_url)){
                    unlink(public_path($post->image_url));
                }
                $file = $request->file('file');
                $filename=$this->saveImage($file,1000,500);
                $data['image_url']=$filename;
            }
            $data['title']= $request['title'];
            $data['slug']= $request['slug'];
            $data['content']= $request['content'];

           $data['is_commentable'] = isset($request->comments) ? false:true;
           $data['status'] = isset($request->status) ? true:false;
            $this->blogPostService->update($data,$id);
            $update_post=$this->blogPostService->find($id);


            $tags = explode(',', $request->tag);

            $sync_array = [];

            foreach ($tags as $tag) {

                if($tag != '' && preg_match("/^[a-z0-9 .\-]+$/i", $tag)){

                    $is_tag = (new TagRepository())->is_tag($tag);

                    if ($is_tag) {

                        array_push($sync_array, $is_tag->id);
                    } else {
                        $tags = new Tag();
                        $tags->name = trim($tag);
                        $tags->save();
                        array_push($sync_array, $tags->id);
                    }
                }
            }

            $update_post->tags()->sync($sync_array);
            $update_post->categories()->sync($request->categories);
            Toastr::success(__('common.operation_done_successfully'),__('common.success'));
            DB::commit();
            LogActivity::successLog('blog post updated.');
            return redirect()->route('blog.posts.index');
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        try {
            $post=$this->blogPostService->find($id);
            $post->tags()->detach();
            $post->categories()->detach();
            if (file_exists($post->image_url)) {
                unlink(public_path($post->image_url));
            }
            $post->delete();
            Toastr::success(__('common.operation_done_successfully'),__('common.success'));

            LogActivity::successLog('blog post deleted.');
            return redirect()->route('blog.posts.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
           Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }

    //approval
    public function approval(Request $request){

        $post=$this->blogPostService->find($request->id);
        if ($post->is_approved == false)
        {
            $post->is_approved = true;
            $post->approved_by = auth()->user()->id;
            $post->save();
            $user=User::where('id',$post->user->id)->get();
            $details['body']= 'Your Post Has Been Approved ';
            Notification::send($user, new NewAuthorPost($details));
            LogActivity::successLog('post approved.');
            return response()->json([
                'success'=>__('blog.post_successfully_approved')
            ]);
        } else {
            return response()->json([
                'success'=>__('blog.this_post_is_already_approved')
            ]);
        }

    }

    //change status
    public function statusUpdate(Request $request)
    {
        try {
            $data = [
                'status' => $request->status == 1 ? 0 : 1
            ];
            LogActivity::successLog('blog status update successful.');
            return $this->blogPostService->statusUpdate($data, $request->id);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }


    //delete specific post image
    public function deletePostImage(Request $request){
         try {
            return $this->blogPostService->deletePostImg($request->id);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }

    }



}
