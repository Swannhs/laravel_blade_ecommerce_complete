<?php
namespace Modules\OrderManage\Services;

use Modules\OrderManage\Repositories\OrderManageRepository;
use Illuminate\Support\Arr;

class OrderManageService
{
    protected $ordermanageRepository;

    public function __construct(OrderManageRepository $ordermanageRepository){
        $this->ordermanageRepository = $ordermanageRepository;
    }

    public function myConfirmedSalesList()
    {
        return $this->ordermanageRepository->myConfirmedSalesList();
    }

    public function myCompletedSalesList()
    {
        return $this->ordermanageRepository->myCompletedSalesList();
    }

    public function myPendingPaymentSalesList()
    {
        return $this->ordermanageRepository->myPendingPaymentSalesList();
    }

    public function myCancelledPaymentSalesList()
    {
        return $this->ordermanageRepository->myCancelledPaymentSalesList();
    }

    public function totalSalesList()
    {
        return $this->ordermanageRepository->totalSalesList();
    }

    public function findOrderByID($id)
    {
        return $this->ordermanageRepository->findOrderByID($id);
    }

    public function findOrderPackageByID($id)
    {
        return $this->ordermanageRepository->findOrderPackageByID($id);
    }

    public function orderInfoUpdate($data, $id)
    {
        return $this->ordermanageRepository->orderInfoUpdate($data, $id);
    }

    public function updateDeliveryStatus($data, $id)
    {
        return $this->ordermanageRepository->updateDeliveryStatus($data, $id);
    }

    public function updateDeliveryStatusRecieve($data)
    {
        return $this->ordermanageRepository->updateDeliveryStatusRecieve($data);
    }

    public function sendDigitalFileAccess($data)
    {
        return $this->ordermanageRepository->sendDigitalFileAccess($data);
    }

    public function DigitalFileDownload($slug)
    {
        return $this->ordermanageRepository->DigitalFileDownload($slug);
    }

    public function orderConfirm($id){
        return $this->ordermanageRepository->orderConfirm($id);
    }

    public function getTrackOrderConfiguration()
    {
        return $this->ordermanageRepository->getTrackOrderConfiguration();
    }


    public function trackOrderConfigurationUpdate($request)
    {
        return $this->ordermanageRepository->trackOrderConfigurationUpdate($request);
    }

    public function getPackageInfo($id){
        return $this->ordermanageRepository->getPackageInfo($id);
    }

}
