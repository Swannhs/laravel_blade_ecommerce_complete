<?php

namespace Modules\GiftCard\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GiftCard\Http\Requests\CreateGiftCardRequest;
use Modules\GiftCard\Http\Requests\UpdateGiftCardRequest;
use Illuminate\Support\Facades\DB;
use Modules\GiftCard\Entities\GiftcardTag;
use Modules\GiftCard\Services\GiftCardService;
use Modules\UserActivityLog\Traits\LogActivity;
use Yajra\DataTables\Facades\DataTables;

class GiftCardController extends Controller
{
    protected $giftcardService;

    public function __construct(GiftCardService $giftcardService)
    {
        $this->giftcardService = $giftcardService;
        $this->middleware(['auth','maintenance_mode']);
    }

    public function index()
    {
        return view('giftcard::giftcard.index');
    }

    public function bulk_upload_page()
    {
        return view('giftcard::giftcard.bulk_upload');
    }

    public function bulk_store (Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx|max:2048'
        ]);
        ini_set('max_execution_time', 0);
        DB::beginTransaction();
        try {
            $this->giftcardService->csvUploadCategory($request->except("_token"));
            DB::commit();
            Toastr::success(__('common.uploaded_successfully'),__('common.success'));
            LogActivity::successLog('gift card uploaded.');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            if ($e->getCode() == 23000) {
                Toastr::error(__('common.duplicate_entry_is_exist_in_your_file'));
            }
            else {
                Toastr::error(__('common.operation_failed'));
            }
            return back();
        }
    }

    public function getData(){
        $card = $this->giftcardService->getAll();

        return DataTables::of($card)
            ->addIndexColumn()

            ->addColumn('number_of_sale', function($card){
                return count($card->uses);
            })
            ->addColumn('status', function($card){
                return view('giftcard::giftcard.components._status_td',compact('card'));
            })
            ->addColumn('thumbnail_image', function($card){
                return view('giftcard::giftcard.components._thumbnail_image_td',compact('card'));
            })
            ->addColumn('action', function($card){
                return view('giftcard::giftcard.components._action_td',compact('card'));
            })
            ->rawColumns(['status','thumbnail_image','action'])
            ->toJson();
    }


    public function create()
    {
        $shippings = $this->giftcardService->getShipping();
        return view('giftcard::giftcard.create',compact('shippings'));
    }


    public function store(CreateGiftCardRequest $request)
    {
        DB::beginTransaction();
        $this->giftcardService->store($request->except('_token'));
        DB::commit();
        LogActivity::successLog('gift card created');
        Toastr::success(__('common.created_successfully'), __('common.success'));
        return redirect()->route('admin.giftcard.index');


    }

    public function statusChange(Request $request){
        try{
            $this->giftcardService->statusChange($request->except('_token'));
            LogActivity::successLog('gift card status changed');
            return response()->json([
                'success' => 'Status Updated Successfully'
            ],200);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());

            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }


    }


    public function show($id)
    {
        $card = $this->giftcardService->getById($id);
        return view('giftcard::giftcard.view',compact('card'));
    }


    public function edit($id)
    {
        $card = $this->giftcardService->getById($id);
        $shippings = $this->giftcardService->getShipping();
        return view('giftcard::giftcard.edit',compact('card', 'shippings'));
    }


    public function update(UpdateGiftCardRequest $request, $id)
    {
        
        $this->giftcardService->update($request->except('_token'),$id);
        LogActivity::successLog('gift card updated');
        Toastr::success(__('common.updated_successfully'), __('common.success'));
        return redirect()->route('admin.giftcard.index');

    }



    public function destroy(Request $request)
    {
        try{
            $result = $this->giftcardService->deleteById($request->id);
            
            if ($result == "not_possible") {
                return response()->json([
                    'msg' => __('common.related_data_exist_in_multiple_directory')
                ]);
            }
            else {
                LogActivity::successLog('gift card deleted');
                return view('giftcard::giftcard.components._list');
            }
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }
}
