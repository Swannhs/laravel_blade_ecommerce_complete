<?php

namespace Modules\FrontendCMS\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \Modules\FrontendCMS\Services\AboutUsService;
use Exception;
use Modules\FrontendCMS\Http\Requests\AboutUsRequest;
use Modules\UserActivityLog\Traits\LogActivity;

class AboutUsController extends Controller
{
    protected $aboutusService;

    public function __construct(AboutUsService $aboutusService)
    {
        $this->middleware('maintenance_mode');
        $this->aboutusService = $aboutusService;
    }
    public function index()
    {

        try {
            $aboutus = $this->aboutusService->getAll();

            return view('frontendcms::aboutus.index',compact('aboutus'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status'    =>  false,
                'message'   =>  $e
            ]);
        }

    }


    public function update(AboutUsRequest $request, $id)
    {

        try {
            $this->aboutusService->update($request->only('mainTitle', 'subTitle', 'mainDescription','sec1_image','sec2_image',
             'benifitTitle', 'benifitDescription','sellingTitle','sellingDescription','slug','price'), $id);

            Toastr::success(__('common.updated_successfully'),__('common.success'));
            LogActivity::successLog('About us updated.');
            return redirect()->route('frontendcms.about-us.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status'    =>  false,
                'message'   =>  $e->getMessage().$e->getLine()
            ]);
        }
    }

}
