<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\WishlistService;
use Exception;
use Modules\UserActivityLog\Traits\LogActivity;

class WishlistController extends Controller
{
    protected $wishlistService;

    public function __construct(WishlistService $wishlistService){
        $this->wishlistService = $wishlistService;
        $this->middleware(['maintenance_mode','auth']);
    }

    public function index()
    {
        try{
            $data['products'] = $this->wishlistService->myWishlist(auth()->user()->id);
            if (auth()->user()->role->type != 'customer') {
                return view('backEnd.pages.customer_data.wishlist', $data);
            }
            else {
                return view(theme('pages.profile.wishlist'), $data);
            }
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }


    public function my_wish_list(){

        try{
            $page = null;
            $sort_by = $_GET['sort_by'];
            $paginate = $_GET['paginate'];
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }
            if(isset($_GET['paginate'])){
                $data['paginate'] = $_GET['paginate'];
            }
            if(isset($_GET['sort_by'])){
                $data['sort_by'] = $_GET['sort_by'];
            }
            $data['products'] = $this->wishlistService->myWishlistWithPaginate(['page' => $page, 'sort_by' => $sort_by, 'paginate' => $paginate]);
            if (auth()->user()->role->type != 'customer') {
                return view('backEnd.pages.customer_data._wishlist_with_paginate', $data);
            }
            else {
                return view(theme('pages.profile.partials._wishlist_with_paginate'), $data);
            }
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function store(Request $request)
    {
        $result = $this->wishlistService->store($request->except('_token'), auth()->user());
        $totalItems = $this->countWishlist();
        return response()->json([
            'result' => $result,
            'totalItems' => $totalItems
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        try{
            $this->wishlistService->remove($request->id, auth()->user()->id);

            $page = null;
            $sort_by = $request->sort_by;
            $paginate = $request->paginate;
            if(isset($request->page)){
                $page = $request->page;
            }
            if(isset($request->paginate)){
                $data['paginate'] = $request->paginate;
            }
            if(isset($request->sort_by)){
                $data['sort_by'] = $request->sort_by;
            }
            $data['products'] = $this->wishlistService->myWishlistWithPaginate(['page' => $page, 'sort_by' => $sort_by, 'paginate' => $paginate]);
            if (auth()->user()->role->type != 'customer') {
                return view('backEnd.pages.customer_data._wishlist_with_paginate', $data);
            }
            else {
                $totalItems = $this->countWishlist();
                return response()->json([
                    'page' => (string)view(theme('pages.profile.partials._wishlist_with_paginate'), $data),
                    'totalItems' => $totalItems
                ]);
            }

        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());

            return 0;
        }
    }

    private function countWishlist(){
        $totalItems = 0;
        if(auth()->check()){
            $totalItems = $this->wishlistService->totalWishlistItem(auth()->user()->id);
        }
        return $totalItems;

    }
}
