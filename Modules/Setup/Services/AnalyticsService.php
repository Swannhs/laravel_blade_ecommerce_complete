<?php
namespace Modules\Setup\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Setup\Repositories\AnalyticsRepository;

class AnalyticsService
{
    protected $analyticsRepository;

    public function __construct(AnalyticsRepository  $analyticsRepository)
    {
        $this->analyticsRepository = $analyticsRepository;
    }

    public function getAnalytics(){
        return $this->analyticsRepository->getAnalytics();
    }

    public function getBusinessData(){
        return $this->analyticsRepository->getBusinessData();
    }

    public function googleAnalyticsUpdate($data){
        return $this->analyticsRepository->googleAnalyticsUpdate($data);
    }

    public function facebookPixelUpdate($data){
        return $this->analyticsRepository->facebookPixelUpdate($data);
    }
    
}
