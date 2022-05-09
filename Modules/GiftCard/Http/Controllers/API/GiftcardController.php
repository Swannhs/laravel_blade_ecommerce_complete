<?php

namespace Modules\GiftCard\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\GiftCardRepository;

class GiftcardController extends Controller
{
    protected $giftcardRepository;
    public function __construct(GiftCardRepository $giftcardRepository){
        $this->giftcardRepository = $giftcardRepository;
    }

    // Giftcard List

    public function index(){
        $giftcards = $this->giftcardRepository->getAll('new',10);
        if(count($giftcards) > 0){
            return response()->json([
                'giftcards' => $giftcards,
                'seller' => app('general_setting')->company_name,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'giftcards' => $giftcards,
                'message' => 'List empty.'
            ], 404);
        }
    }

    // Single Giftcard


    public function giftcard($slug){
        $giftcard = $this->giftcardRepository->getBySlug($slug);

        if($giftcard){
            return response()->json([
                'giftcard' => $giftcard,
                'seller' => app('general_setting')->company_name,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'not found'
            ],404);
        }
    }




    // Customers Purchased Giftcards
    public function myPurchasedGiftcardList(Request $request){

        $giftcards = $this->giftcardRepository->myPurchasedGiftCard($request->user());
        if(count($giftcards) > 0){
            return response()->json([
                'giftcards' => $giftcards,
                'message' => 'Success'
            ],200);
        }else{
            return response()->json([
                'message' => 'list is empty'
            ],404);
        }
    }

    // Giftcard add to wallet
     public function giftcardAddToWallet(Request $request){

        $request->validate([
            'secret_code' => 'required'
        ]);

        $result = $this->giftcardRepository->myPurchasedGiftCardRedeemToWalletFromWalletRecharge($request->all(), $request->user());
        if($result == 'success'){
            return response()->json([
                'mesage' => 'Redeem Successfully'
            ],201);
        }
        elseif($result == 'used'){
            return response()->json([
                'mesage' => 'Allready Used'
            ],202);
        }else{
            return response()->json([
                'mesage' => 'Invalid Gift card'
            ],404);
        }

     }
}
