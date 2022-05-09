<?php

namespace Modules\Wallet\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \Modules\Wallet\Services\WithdrawRequestService;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;
use Yajra\DataTables\Facades\DataTables;

class WithdrawRequestController extends Controller
{
    protected $walletRequestService;

    public function __construct(WithdrawRequestService  $walletRequestService)
    {
        $this->middleware('maintenance_mode');
        $this->walletRequestService = $walletRequestService;
    }

    public function index()
    {
        return view('wallet::backend.seller.withdraw_requests.index');
    }

    public function my_withdraw_request_get_data(){
        $transaction = $this->walletRequestService->getMyAll();

        return DataTables::of($transaction)
        ->addIndexColumn()
        ->addColumn('date', function($transaction){
            return date(app('general_setting')->dateFormat->format, strtotime($transaction->created_at));
        })
        ->addColumn('amount',function($transaction){
            return single_price($transaction->amount);

        })
        ->addColumn('payment_method', function($transaction){
            return $transaction->GatewayName;
        })
        ->addColumn('approval',function($transaction){
            return view('wallet::backend.seller.withdraw_requests.components._approval_td',compact('transaction'));
        })
        ->addColumn('action',function($transaction){
            return view('wallet::backend.seller.withdraw_requests.components._action_td',compact('transaction'));
        })
        ->rawColumns(['approval','action'])
        ->toJson();
    }

    public function withdraw_requests()
    {
        return view('wallet::backend.admin.withdraw_requests.index');
    }

    public function withdraw_requests_get_data(){
        $transaction = $this->walletRequestService->getAll();

        return DataTables::of($transaction)
        ->addIndexColumn()
        ->addColumn('date', function($transaction){
            return date(app('general_setting')->dateFormat->format, strtotime($transaction->created_at));
        })
        ->addColumn('user', function($transaction){
            return @$transaction->user->first_name .' '. @$transaction->user->last_name;

        })
        ->addColumn('amount',function($transaction){
            return single_price($transaction->amount);

        })
        ->addColumn('payment_method', function($transaction){
            return $transaction->GatewayName;
        })
        ->addColumn('approval',function($transaction){
            return view('wallet::backend.admin.withdraw_requests.components._approval_td',compact('transaction'));
        })
        ->addColumn('approval',function($transaction){
            return view('wallet::backend.admin.withdraw_requests.components._approval_td',compact('transaction'));
        })
        ->addColumn('action',function($transaction){
            return view('wallet::backend.admin.withdraw_requests.components._action_td',compact('transaction'));
        })
        ->rawColumns(['txn_id','approval','action'])
        ->toJson();
    }

    public function withdraw_requests_show($id){
        $transaction = $this->walletRequestService->findWidrawRequestById($id);
        return view('wallet::backend.admin.withdraw_requests.withdraw_modal', compact('transaction'));
    }

    public function withdraw_request_store(Request $request)
    {
        $this->walletRequestService->withdrawRequestStore($request->except("_token"));
        try {
            Toastr::success(__('wallet.withdraw_request_has_been_sent_successfully'), __('common.success'));
            LogActivity::successLog('Withdraw Request has been sent Successfully.');
            return redirect()->route('my-wallet.withdraw_index');
        } catch (\Exception $e) {
            Toastr::error(__('common.error_message'), __('common.error'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function withdraw_request_update(Request $request)
    {
        try {
            $this->walletRequestService->withdrawRequestUpdate($request->except("_token"));
            Toastr::success(__('wallet.withdraw_request_has_been_modified_successfully'), __('common.success'));
            LogActivity::successLog('Withdraw Request has been modified Successfully.');
            return redirect()->route('my-wallet.withdraw_index');
        } catch (\Exception $e) {
            Toastr::error(__('common.error_message'), __('common.error'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function withdraw_request_status_update(Request $request, $id)
    {
        try {
            $this->walletRequestService->withdrawRequestStatusUpdate($request->except("_token"), $id);
            LogActivity::successLog('Withdraw Request has been Approved Successfully.');
            return response()->json(["message" => "Approval Updated Successfully"], 200);
        } catch (\Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }
}
