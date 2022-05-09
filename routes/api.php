<?php

use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\CouponController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\SellerController;
use App\Http\Controllers\API\SupportTicketController;
use App\Http\Controllers\API\WishListController;
use App\Http\Controllers\Auth\API\AuthController;
use App\Http\Controllers\Auth\API\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login', [AuthController::class,'login']);
Route::post('/register', [AuthController::class,'register']);

Route::middleware('auth:sanctum')->group(function () {

   Route::post('/logout', [AuthController::class,'logout']);
   Route::post('/change-password', [AuthController::class,'changePassword']);
   Route::get('/get-user', [AuthController::class,'getUser']);

   Route::post('/profile/update-information',[ProfileController::class,'profileUpdate']);
   Route::post('/profile/update-photo',[ProfileController::class,'updatePhoto']);
   Route::get('/profile/address-list',[ProfileController::class,'addressList']);
   Route::post('/profile/address-store',[ProfileController::class,'addressStore']);
   Route::post('/profile/address-update/{id}',[ProfileController::class,'addreddUpdate']);
   Route::post('/profile/address-delete',[ProfileController::class,'deleteAddress']);
   Route::post('/profile/default-shipping-address',[ProfileController::class,'defaultShippingAddress']);
   Route::post('/profile/default-billing-address',[ProfileController::class,'defaultBillingAddress']);

   //cart
   Route::get('/cart', [CartController::class,'list']);
   Route::post('/cart',[CartController::class, 'addToCart']);
   Route::post('/cart/remove',[CartController::class, 'removeFromCart']);
   Route::post('/cart/remove-all',[CartController::class, 'removeAllFromCart']);
   Route::post('/cart/select-item',[CartController::class, 'selectItem']);
   Route::post('/cart/select-seller-item',[CartController::class, 'selectSellerItem']);
   Route::post('/cart/select-all',[CartController::class, 'selectAll']);
   Route::post('/cart/update-qty',[CartController::class, 'updateQty']);
   Route::post('/cart/update-shipping-method',[CartController::class, 'updateShippingMethod']);

   //checkout
   Route::get('/checkout', [CheckoutController::class,'list']);

   //coupon apply
   Route::post('/checkout/coupon-apply', [CheckoutController::class,'couponApply']);

   //order
   Route::get('/order-list', [OrderController::class,'allOrderList']);
   Route::get('/order-pending-list', [OrderController::class,'PendingOrderList']);
   Route::get('/order-cancel-list', [OrderController::class,'cancelOrderList']);
   Route::post('/order-store', [OrderController::class,'orderStore']);
   Route::get('/order/{order_number}', [OrderController::class,'singleOrder']);

   Route::post('/order-payment-info-store', [OrderController::class,'paymentInfoStore']);

   Route::get('/order-to-ship',[OrderController::class,'orderToShip']);
   Route::get('/order-to-receive',[OrderController::class,'orderToReceive']);

   Route::get('/order-refund-list', [OrderController::class,'refundOrderList']);
   // track order for registerd customer
   Route::post('/order-track', [OrderController::class,'orderTrack']);

   //order review package wise
   Route::get('/order-review', [OrderController::class,'OrderReviewPackageWise']);
   Route::post('/order-review', [OrderController::class,'OrderReview']);

   //waiting for review list
   Route::get('/order-review/waiting-for-review-list', [OrderController::class,'waitingForReview']);

    // review list
   Route::get('/order-review/list', [OrderController::class,'ReviewList']);

   //make refund
   Route::get('/order-refund/{id}', [OrderController::class,'makeRefundData']);
   Route::post('/order-refund/store', [OrderController::class,'refundStore']);

   //customer coupon list
   Route::get('/coupon', [CouponController::class,'index']);
   Route::post('/coupon', [CouponController::class,'store']);
   Route::post('/coupon/delete', [CouponController::class,'destroy']);

   //wishlist for customer
   Route::get('/wishlist', [WishListController::class,'index']);
   Route::post('/wishlist', [WishListController::class,'store']);
   Route::post('/wishlist/delete', [WishListController::class,'destroy']);

   // get customers data
   Route::get('/profile/get-customer-data', [ProfileController::class,'getCustomerData']);

   // support ticket
   Route::get('/ticket-list', [SupportTicketController::class,'index']);
   Route::get('/ticket-list-get-data', [SupportTicketController::class,'getTicketsWithPaginate']);
   Route::post('/ticket-store', [SupportTicketController::class,'store']);
   Route::get('/ticket-show/{id}', [SupportTicketController::class,'show']);
   Route::get('/ticket/categories', [SupportTicketController::class,'categoryList']);
   Route::get('/ticket/priorities', [SupportTicketController::class,'priorityList']);
   Route::post('/ticket-show/reply', [SupportTicketController::class,'replyTicket']);

});

// track order for guest customer
   Route::post('/order-track-guest', [OrderController::class,'orderTrack']);

// forgot password api
   Route::post('/forgot-password', [AuthController::class,'forgotPasswordAPI']);

// seller list api
   Route::get('/seller-list', [SellerController::class,'sellerList']);
   Route::get('/seller-profile/{id}', [SellerController::class,'getSellerById']);

// filter from seller profile
   Route::post('/seller/filter-by-type', [SellerController::class,'filterByType']);
   Route::post('/seller/filter-by-type-after-sort', [SellerController::class,'filterAfterSort']);


// search api
Route::post('/live-search', [SearchController::class,'liveSearch']);




