<?php

namespace Modules\OrderManage\Http\Controllers\API;

use App\Services\OrderService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\OrderManage\Repositories\CancelReasonRepository;
use Modules\UserActivityLog\Traits\LogActivity;


class OrderCancelReasonController extends Controller
{
    protected $cancelReasonRepository;
    protected $orderService;
    public function __construct(CancelReasonRepository $cancelReasonRepository, OrderService $orderService){
        $this->cancelReasonRepository = $cancelReasonRepository;
        $this->orderService = $orderService;
    }

    // Order Cancel Reasons

    public function index(){
        $reasons = $this->cancelReasonRepository->getAll();
        if(count($reasons) > 0){
            return response()->json([
                'reasons' => $reasons,
                'message' => 'success'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Empty list'
            ], 404);
        }
    }

    // Single Order Cancel Reason

    public function reason($id){
        $reason = $this->cancelReasonRepository->getById($id);
        if($reason){
            return response()->json([
                'reason' => $reason,
                'message' => 'success'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }
    }

    // Order Cancel

    public function cancelStore(Request $request){

        $request->validate([
            'order_id' => 'required',
            'reason' => 'required',
        ]);

        try {
            $data = $this->orderService->orderFindByOrderID($request->order_id);
            if($data){
                if($request->user()->id == $data->customer_id && $data->is_confirmed != 1){
                    $data->update([
                        'is_cancelled' => 1,
                        'cancel_reason_id' => $request->reason
                    ]);
                    LogActivity::successLog('Purchase order cancel successful for '.$request->user()->first_name);
                    return response()->json([
                        'message' => 'Order Cancelled Successfully'
                    ],202);
                }else {
                    return response()->json([
                        'message' => 'Order not found'
                    ],404);
                }
            }else{
                return response()->json([
                    'message' => 'Order Cancelled Failed'
                ],302);
            }

            return 'ok';
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'message' => 'order not cancelled. error occured'
            ],503);

        }
    }


}
