<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\GiftCardService;
use Modules\Shipping\Repositories\ShippingRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Modules\UserActivityLog\Traits\LogActivity;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class GiftCardController extends Controller
{
    protected $giftCardService;

    public function __construct(GiftCardService $giftCardService)
    {
        $this->giftCardService = $giftCardService;
        $this->middleware('maintenance_mode');
    }

    public function index()
    {

        $data['cards'] = $this->giftCardService->getAll(null, null);
        $data['max_price'] = $this->giftCardService->getMaxPrice();
        $data['min_price'] = $this->giftCardService->getMinPrice();
        
        return view(theme('pages.giftcard'), $data);
    }

    public function fetchData(Request $request)
    {
        $sort_by = null;
        $paginate = null;
        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
            $data['sort_by'] = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $paginate = $request->paginate;
            $data['paginate'] = $request->paginate;
        }
        $data['cards'] = $this->giftCardService->getAll($sort_by, $paginate);
        return view(theme('partials._giftcard_list'), $data);
    }

    public function filterByType(Request $request)
    {

        $paginate = null;
        $sort_by = null;
        if ($request->has('paginate')) {
            $data['paginate'] = $request->paginate;
        }
        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
            $data['sort_by'] = $request->sort_by;
        }
        
        $data['cards'] =  $this->giftCardService->getByFilterByType($request->except('_token'), $sort_by, $paginate);

        return view(theme('partials._giftcard_list'), $data);
    }

    public function filterPaginateDataByType(Request $request)
    {
        $sort_by = null;
        $paginate = null;
        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
            $data['sort_by'] = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $paginate = $request->paginate;
            $data['paginate'] = $request->paginate;
        }
        $data['cards'] = $this->giftCardService->getByFilterByType(session()->get('filtergiftCard'), $sort_by, $paginate);

        return view(theme('partials._giftcard_list'), $data);
    }


    public function show($slug)
    {

        $card = $this->giftCardService->getBySlug($slug);
        $shippingService = new ShippingRepository;
        $shipping_method_id = $shippingService->getAll()->where('id', 1)->first();
        $reviews = $card->reviews->where('status', 1)->pluck('rating');
        $cards = $this->giftCardService->getForFrontend($slug);

        if (count($reviews) > 0) {
            $value = 0;
            $rating = 0;
            foreach ($reviews as $review) {
                $value += $review;
            }
            $rating = $value / count($reviews);
            $total_review = count($reviews);
        } else {
            $rating = 0;
            $total_review = 0;
        }

        return view(theme('pages.giftcard_details'), compact('card', 'rating', 'total_review', 'shipping_method_id', 'cards'));
    }

    public function purchased_gift_card()
    {
        if (auth()->user()->role->type != 'customer') {
            $gift_card_infos = $this->giftCardService->myPurchasedGiftCardAll(auth()->user());
            LogActivity::successLog('all purchased gift card successful.');
            return view('backEnd.pages.customer_data.purchased_gift_card', compact('gift_card_infos'));
        } else {
            $gift_card_infos = $this->giftCardService->myPurchasedGiftCard(auth()->user());
            LogActivity::successLog('purchased gift card successful.');
            return view(theme('pages.profile.purchased_gift_card'), compact('gift_card_infos'));
        }
    }

    public function gift_card_redeem(Request $request)
    {
        try {
            $this->giftCardService->myPurchasedGiftCardRedeem($request->except('_token'), auth()->user());
            return 1;
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    public function recharge_via_gift_card(Request $request)
    {
        $request->validate([
            'secret_code' => 'required'
        ]);

        try {
            $result = $this->giftCardService->myPurchasedGiftCardRedeemToWalletFromWalletRecharge($request->except('_token'), auth()->user());
            if($result == 'success'){
                Toastr::success(__('product.redeem_successfully'), __('common.success'));
            }
            elseif($result == 'used'){
                Toastr::error(__('product.gift_card_already_used'), __('common.error'));
            }else{
                Toastr::error(__('product.invalid_giftcard'), __('common.error'));
            }
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return back();
        }
    }

    public function getReviewByPage(Request $request)
    {
        $reviews = $this->giftCardService->getReviewByPage($request->only('page', 'giftcard_id'));
        return view(theme('partials._giftcard_review_with_paginate'), compact('reviews'));
    }
}
