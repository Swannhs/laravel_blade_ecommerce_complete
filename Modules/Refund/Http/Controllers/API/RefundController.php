<?php

namespace Modules\Refund\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Refund\Repositories\RefundProcessRepository;
use Modules\Refund\Repositories\RefundReasonRepository;



class RefundController extends Controller
{
    protected $refundReasonRepository;
    protected $refundProcessRepository;

    public function __construct(RefundReasonRepository $refundReasonRepository, RefundProcessRepository $refundProcessRepository){
        $this->refundReasonRepository = $refundReasonRepository;
        $this->refundProcessRepository = $refundProcessRepository;
    }

    //refund reason


    public function ReasonList(){
        $reasons = $this->refundReasonRepository->getAll();
        if(count($reasons) > 0){
            return response()->json([
                'reasons' => $reasons,
                'measege' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'list is empty'
            ],404);
        }
    }

    // Single Refund Reason

    public function reason($id){
        $reason = $this->refundReasonRepository->getById($id);

        if($reason){
            return response()->json([
                'reason' => $reason,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'not found'
            ],404);
        }
    }


    //refund process

    public function processList(){
        $processes = $this->refundProcessRepository->getAll();
        if(count($processes) > 0){
            return response()->json([
                'processes' => $processes,
                'measege' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'list is empty'
            ],404);
        }
    }

    // Single Process

    public function process($id){
        $process = $this->refundProcessRepository->getById($id);
        if($process){
            return response()->json([
                'process' => $process,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'not found'
            ],404);
        }
    }


    
}
