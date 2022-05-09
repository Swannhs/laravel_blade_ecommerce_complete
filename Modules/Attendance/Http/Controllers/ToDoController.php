<?php

namespace Modules\Attendance\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Attendance\Entities\ToDo;
use Modules\UserActivityLog\Traits\LogActivity;

class ToDoController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }
    public function index()
    {
        return view('attendance::index');
    }

    public function create()
    {
        return view('attendance::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required',
        ]);

        try {
            $todo = new ToDo;
            $todo->title = $request->title;
            $todo->date = date('Y-m-d', strtotime($request->date));
            $todo->save();
            Toastr::success(trans('todo.To Do Created Successfully'));

            LogActivity::successLog('todo created successful.');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(trans('common.Something Went Wrong'));
            return back();
        }

    }

    public function completeToDo(Request $request)
    {

        try {
            $todo = ToDo::find($request->id);
            $todo->update(['status' => 1]);
            LogActivity::successLog('todo mark as complete successful.');
            return response()->json(['success' => trans('todo.To Do Has Been Marked as Complete')]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(['success' => trans('common.Something Went Wrong')]);
        }
    }

    public function completeList()
    {
        return ToDo::where('status',1)->get();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('attendance::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('attendance::edit');
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
