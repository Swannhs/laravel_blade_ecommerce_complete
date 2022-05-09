<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Blog\Entities\BlogComment;
use Modules\UserActivityLog\Traits\LogActivity;

class BlogCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','maintenance_mode']);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function comment(Request $request, $post_id)
    {

        $request->validate([
            'comment' => 'required',
            ]);

        try{
            BlogComment::create([
                'comment'=>$request['comment'],
                'blog_post_id' => $post_id,
                'user_id' => auth()->user()->id
            ]);
            LogActivity::successLog('comment added successful.');
            Toastr::success(__('blog.comments_create_successfully'),__('common.success'));
            return redirect()->back();
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('blog::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('blog::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('blog::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
