<?php

namespace Modules\FrontendCMS\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \Modules\FrontendCMS\Services\MerchantContentService;
use \Modules\FrontendCMS\Services\BenefitService;
use \Modules\FrontendCMS\Services\WorkingProcessService;
use \Modules\FrontendCMS\Services\FaqService;
use \Modules\FrontendCMS\Services\PricingService;
use Exception;
use Modules\FrontendCMS\Http\Requests\UpdateMerchantContentRequest;
use Modules\UserActivityLog\Traits\LogActivity;

class MerchantContentController extends Controller
{
    protected $merchantContentService;
    protected $benefitService;
    protected $faqService;
    protected $workingProcessService;
    protected $pricingService;

    public function __construct(MerchantContentService $merchantContentService, BenefitService $benefitService,
     WorkingProcessService $workingProcessService, FaqService $faqService, PricingService $pricingService)
    {
        $this->middleware('maintenance_mode');
        $this->merchantContentService = $merchantContentService;
        $this->benefitService = $benefitService;
        $this->faqService = $faqService;
        $this->workingProcessService = $workingProcessService;
        $this->pricingService = $pricingService;
    }

    public function index()
    {
        try {
            $content = $this->merchantContentService->getAll();
            $selectedPricing = explode(',',$content->pricing_id);
            $BenefitList = $this->benefitService->getAll();
            $WorkingProcessList = $this->workingProcessService->getAll();
            $FaqList = $this->faqService->getAll();
            $PricingList = $this->pricingService->getAll();
            return view('frontendcms::merchant.index', compact('content','BenefitList','WorkingProcessList','FaqList','PricingList','selectedPricing'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status'    =>  false,
                'message'   =>  $e->getMessage()
            ]);
        }
    }

    public function update(UpdateMerchantContentRequest $request)
    {
        try {
            $data = $this->merchantContentService->update($request->only(
                'mainTitle',
                'subTitle',
                'slug',
                'Maindescription',
                'pricing',
                'benifitTitle',
                'benifitDescription',
                'howitworkTitle',
                'howitworkDescription',
                'pricingTitle',
                'pricingDescription',
                'sellerRegistrationTitle',
                'sellerRegistrationDescription',
                'queryTitle',
                'queryDescription',
                'faqTitle',
                'faqDescription',
                'pricing_id'
            ), $request->id);
            LogActivity::successLog('Merchant content updated.');
            return $data;
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status'    =>  false,
                'message'   =>  $e->getMessage()
            ]);
        }
    }
}
