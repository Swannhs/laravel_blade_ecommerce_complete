<?php

namespace Modules\FooterSetting\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FooterSetting\Http\Requests\FooterWidgetRequest;
use \Modules\FooterSetting\Services\FooterSettingService;
use \Modules\FrontendCMS\Services\DynamicPageService;
use \Modules\FooterSetting\Services\FooterWidgetService;
use Exception;
use Illuminate\Support\Facades\Session;
use Modules\UserActivityLog\Traits\LogActivity;

class FooterSettingController extends Controller
{
    protected $footerService;
    protected $dynamicPageService;
    protected $widgetService;

    public function __construct(FooterSettingService $footerService, DynamicPageService $dynamicPageService, FooterWidgetService $widgetService)
    {
        $this->middleware(['maintenance_mode','admin']);
        $this->footerService = $footerService;
        $this->dynamicPageService = $dynamicPageService;
        $this->widgetService = $widgetService;
    }

    public function index()
    {
        try {
            $FooterContent = $this->footerService->getAll();
            $dynamicPageList  = $this->dynamicPageService->getActiveAll();
            $SectionOnePages  = $this->widgetService->getAllCompany();
            $SectionTwoPages  = $this->widgetService->getAllAccount();
            $SectionThreePages  = $this->widgetService->getAllService();
            return view('footersetting::footer.index', compact('FooterContent', 'dynamicPageList', 'SectionOnePages', 'SectionTwoPages', 'SectionThreePages'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }



    public function widgetStore(FooterWidgetRequest $request)
    {


        try {
            $this->widgetService->save($request->except('_token'));

            $notification = array(
                'messege' => __('common.created_successfully'),
                'alert-type' => 'success'
            );
            LogActivity::successLog('Widget added.');
            return redirect()->back()->with($notification);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }
    public function widgetStatus(Request $request)
    {
        try {
            $data = [
                'status' => $request->status == 1 ? 0 : 1
            ];
            LogActivity::successLog('Widget status changed.');
            return $this->widgetService->statusUpdate($data, $request->id);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }


    public function show($id)
    {
        return view('footersetting::show');
    }



    public function widgetUpdate(FooterWidgetRequest $request)
    {

        try {
            $this->widgetService->update($request->except('_token'), $request->id);
            Toastr::success(__('common.updated_successfully'),__('common.success'));
            LogActivity::successLog('Widget updated.');
            return redirect()->route('footerSetting.footer.index');

        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function contentUpdate(Request $request)
    {
        try {
            $update =  $this->footerService->update($request->except('_token'), $request->id);
            LogActivity::successLog('footer Content updated.');
            return $update;
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }


    public function destroy($id)
    {
        try {
            $this->widgetService->delete($id);
            Toastr::success(__('common.deleted_successfully'));
            LogActivity::successLog('Widget deleted.');
            return redirect()->route('footerSetting.footer.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function tabSelect($id){
        Session::put('footer_tab',$id);
        return 'done';
    }
}
