<?php

namespace Modules\Setup\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Setup\Http\Requests\IntroPrefixFormRequest;
use Modules\Setup\Services\IntroPrefixService;

class IntroPrefixController extends Controller
{
    protected $introPrefixService;

    public function __construct(IntroPrefixService $introPrefixService)
    {
        $this->middleware('maintenance_mode');
        $this->introPrefixService = $introPrefixService;
    }

    public function index(Request $request)
    {
        try{
            $introPrefixes = $this->introPrefixService->getAll();
            return view('setup::introPrefixes.index', [
                "introPrefixes" => $introPrefixes,
            ]);
        } catch (\Exception $e) {
            \LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function Store(IntroPrefixFormRequest $request)
    {
        try {
            $this->introPrefixService->create($request->except("_token"));
            \LogActivity::successLog('New Intro Prefix - ('.$request->title.') has been created.');
            Toastr::success(__('setup.Intro Prefix has been added Successfully'));
            return redirect()->route('introPrefix.index');
        } catch (\Exception $e) {
            \LogActivity::errorLog($e->getMessage().' - Error has been detected for Intro Prefix creation');
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function edit(Request $request)
    {
        try {
            $introPrefix = $this->introPrefixService->findById($request->id);
            return view('setup::introPrefixes.edit', [
                "introPrefix" => $introPrefix
            ]);
        } catch (\Exception $e) {
            \LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function update(IntroPrefixFormRequest $request, $id)
    {
        try {
            $introPrefix = $this->introPrefixService->update($request->except("_token"), $id);
            \LogActivity::successLog($request->name.'- has been updated.');
            Toastr::success(__('setup.Intro Prefix has been updated Successfully'));
            return back();
        } catch (\Exception $e) {
            \LogActivity::errorLog($e->getMessage().' - Error has been detected for Division update');
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $introPrefix = $this->introPrefixService->delete($id);
            \LogActivity::successLog('A Intro Prefix has been destroyed.');
            Toastr::success(__('setup.A Intro Prefix has been destroyed Successfully'));
            return back();
        } catch (\Exception $e) {
            \LogActivity::errorLog($e->getMessage().' - Error has been detected for Intro Prefix Destroy');
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }
}
