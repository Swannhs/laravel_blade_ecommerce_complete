<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use \Modules\FrontendCMS\Services\BenefitService;
use \Modules\FrontendCMS\Services\AboutUsService;
use Modules\UserActivityLog\Traits\LogActivity;

class AboutUsController extends Controller
{
    protected $benefitService;
    protected $aboutusService;

    public function __construct(AboutUsService $aboutusService, BenefitService $benefitService)
    {
        $this->benefitService = $benefitService;
        $this->aboutusService = $aboutusService;
        $this->middleware('maintenance_mode');
    }
    public function index()
    {
        try{
            $content = $this->aboutusService->getAll();
            $benefitList = $this->benefitService->getAllActive();
            return view(theme('pages.about_us'),compact('content','benefitList'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }
}
