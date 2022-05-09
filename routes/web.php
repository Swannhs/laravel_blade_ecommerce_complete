<?php


use App\Http\Controllers\Frontend\WelcomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\ContactUsController;
use App\Http\Controllers\Frontend\AboutUsController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CareerController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\MerchantController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\ReturnExchangeController;
use App\Http\Controllers\Frontend\LanguageController;
use Modules\OrderManage\Http\Controllers\OrderManageController;
use App\Http\Controllers\Auth\MerchantRegisterController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Frontend\CompareController;
use App\Http\Controllers\Frontend\CouponController;
use App\Http\Controllers\Frontend\FlashDealController;
use App\Http\Controllers\Frontend\GiftCardController;
use App\Http\Controllers\Frontend\NewUserZoneController;
use App\Http\Controllers\Frontend\NotificationController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProductReviewController;
use App\Http\Controllers\Frontend\ReferralController;
use App\Http\Controllers\Frontend\SellerController;
use App\Http\Controllers\Frontend\SupportTicketController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Modules\FrontendCMS\Entities\DynamicPage;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UploadFileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Seller\Entities\SellerProduct;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//for language switcher
Route::post('/locale',[LanguageController::class,'locale'])->name('frontend.locale');

Auth::routes(['verify' => true]);


Route::get('/',[WelcomeController::class,'index'])->name('frontend.welcome');
Route::get('/get-more-products',[WelcomeController::class,'get_more_products'])->name('frontend.get_more_products');
Route::post('/ajax-search-product',[WelcomeController::class,'ajax_search_for_product'])->name('frontend.ajax_search_for_product');
Route::get('/search',[WelcomeController::class,'searchPage'])->name('frontend.searchPage');

Route::get('/secret-logout',[WelcomeController::class,'secret_logout'])->name('secret_logout');
Route::get('/uploads/digital_file/{slug}',[OrderManageController::class,'download'])->name('digital_file_download');

Route::middleware(['admin'])->group(function () {
    Route::get('/admin-dashboard', [ProfileController::class, 'dashboard'])->name('admin.dashboard')->middleware('permission');
    Route::get('/dashboard-cards-info/{type}', [ProfileController::class, 'dashboardCards'])->name('dashboard.card.info');
});
Route::post('search',[SearchController::class,'search'])->name('routeSearch');

//for category page
Route::get('/category',[CategoryController::class,'index'])->name('frontend.category');
Route::get('category/fetch_data', [CategoryController::class,'fetchPagenateData'])->name('frontend.category.fetch-data');
Route::post('/category-filter-product',[CategoryController::class,'filterIndex'])->name('frontend.category_page_product_filter');
Route::get('/category-filter-product-page',[CategoryController::class,'fetchFilterPagenateData'])->name('frontend.category_page_product_filter_page');
Route::post('/filter-product-by-type',[CategoryController::class,'filterIndexByType'])->name('frontend.product_filter_by_type');
Route::get('/filter-product-page-by-type',[CategoryController::class,'fetchFilterPagenateDataByType'])->name('frontend.product_filter_page_by_type');
Route::get('/filter-sort-product-by-type',[CategoryController::class,'sortFilterIndexByType'])->name('frontend.sort_product_filter_by_type');
Route::post('/get-color-by-type', [CategoryController::class,'get_colors_by_type'])->name('frontend.get_colors_by_type');
Route::post('/get-attribute-by-type', [CategoryController::class,'get_attribute_by_type'])->name('frontend.get_attribute_by_type');
Route::post('/get-brand-by-type', [CategoryController::class,'get_brand_by_type'])->name('frontend.get_brands_by_type');

Route::get('/category/{slug}',[CategoryController::class,'productByCategory'])->name('frontend.category-product');

Route::get('/contact-us',[ContactUsController::class,'index'])->name('frontend.contact-us');
Route::get('/about-us',[AboutUsController::class,'index'])->name('frontend.about-us');
Route::get('/merchant',[MerchantController::class,'index'])->name('frontend.merchant');
Route::get('/return-exchange',[ReturnExchangeController::class,'index'])->name('frontend.return-exchange');

//cart
Route::get('/cart',[CartController::class,'index'])->name('frontend.cart')->middleware('customer');
Route::post('/cart/store',[CartController::class,'store'])->name('frontend.cart.store');
Route::post('/cart/update',[CartController::class,'update'])->name('frontend.cart.update');
Route::post('/cart/delete-all',[CartController::class,'destroyAll'])->name('frontend.cart.delete-all');
Route::post('/cart/delete',[CartController::class,'destroy'])->name('frontend.cart.delete');
Route::post('/cart/update-qty',[CartController::class,'updateQty'])->name('frontend.cart.update-qty');
Route::post('/cart/select-all',[CartController::class,'selectAll'])->name('frontend.cart.select-all');
Route::post('/cart/select-all-seller',[CartController::class,'selectAllSeller'])->name('frontend.cart.select-all-seller');
Route::post('/cart/select-item',[CartController::class,'selectItem'])->name('frontend.cart.select-item');
Route::post('/cart/shipping-info-update',[CartController::class,'updateCartShippingInfo'])->name('frontend.cart.update_shipping_info');

//Wishlist
Route::post('/wishlist/store',[WishlistController::class,'store'])->name('frontend.wishlist.store')->middleware('auth');
Route::post('/wishlist/remove',[WishlistController::class,'remove'])->name('frontend.wishlist.remove')->middleware('auth');
Route::get('/my-wishlist',[WishlistController::class,'index'])->name('frontend.my-wishlist')->middleware(['auth','customer']);
Route::get('/my-wishlist/paginate-data',[WishlistController::class,'my_wish_list'])->name('frontend.my-wishlist.paginate-data')->middleware(['auth','customer']);

//compare
Route::get('/compare', [CompareController::class, 'index'])->name('frontend.compare.index');
Route::post('/compare', [CompareController::class, 'store'])->name('frontend.compare.store');
Route::post('/compare/remove', [CompareController::class, 'removeItem'])->name('frontend.compare.remove');
Route::post('/compare/reset', [CompareController::class, 'reset'])->name('frontend.compare.reset');


Route::middleware(['guestCheckout', 'customer'])->group(function () {
    Route::get('/checkout',[CheckoutController::class,'index'])->name('frontend.checkout');
    Route::post('/checkout/billing-address/store',[CheckoutController::class,'billingAddressStore'])->name('frontend.checkout.billing.address.store');
});
//checkout
Route::group(['middleware' => ['auth']], function () {
    Route::post('/checkout/item/delete',[CheckoutController::class,'destroy'])->name('frontend.checkout.item.delete');
    Route::post('/checkout/address/store',[CheckoutController::class,'addressStore'])->name('frontend.checkout.address.store');
    Route::post('/checkout/address/shipping',[CheckoutController::class,'shippingAddressChange'])->name('frontend.checkout.address.shipping');
    Route::post('/checkout/address/billing',[CheckoutController::class,'billingAddressChange'])->name('frontend.checkout.address.billing');
    Route::post('/checkout/coupon-apply',[CheckoutController::class,'couponApply'])->name('frontend.checkout.coupon-apply');
    Route::get('/checkout/coupon-delete',[CheckoutController::class,'couponDelete'])->name('frontend.checkout.coupon-delete');

});

//order
Route::group(['middleware' => ['auth','customer']], function () {
    Route::get('/my-purchase-orders',[OrderController::class,'my_purchase_order_index'])->name('frontend.my_purchase_order_list');
    Route::get('/my-purchase-order-pdf/{id}',[OrderController::class,'my_purchase_order_pdf'])->name('frontend.my_purchase_order_pdf');
    Route::post('/my-purchase-order-cancell',[OrderController::class,'my_purchase_order_cancel'])->name('frontend.order_cancel_by_customer');
    Route::post('/my-purchase-package-order-cancell',[OrderController::class,'my_purchase_order_package_cancel'])->name('frontend.my_purchase_order_package_cancel');
});
    Route::get('/my-purchase-order-details/{id}',[OrderController::class,'my_purchase_order_detail'])->name('frontend.my_purchase_order_detail');

    Route::get('/track-order',[OrderController::class,'track_order'])->name('frontend.order.track');
    Route::post('/order/store',[OrderController::class,'store'])->name('frontend.order.store');
    Route::get('/order/summary/{id}',[OrderController::class,'order_summary'])->name('frontend.order.summary_after_checkout');
    Route::post('/order/payment',[OrderController::class,'payment'])->name('frontend.order_payment');
    Route::post('/track-order',[OrderController::class,'track_order_find'])->name('frontend.order.track_find');


//seller profile
Route::get('/seller-profile/{seller_id}',[SellerController::class,'index'])->name('frontend.seller');
Route::get('seller-profile/{seller_id}/fetch_data', [SellerController::class,'fetchPagenateData'])->name('frontend.seller.fetch-data');
Route::post('seller-profile/get-color-by-type', [SellerController::class,'get_colors_by_type'])->name('frontend.seller.get_colors_by_type');
Route::post('seller-profile/get-attribute-by-type', [SellerController::class,'get_attribute_by_type'])->name('frontend.seller.get_attribute_by_type');
Route::post('/seller-filter-product-by-type',[SellerController::class,'filterIndexByType'])->name('frontend.seller.product_filter_by_type');
Route::get('/seller-filter-product-page-by-type',[SellerController::class,'fetchFilterPagenateDataByType'])->name('frontend.seller.product_filter_page_by_type');
Route::get('/seller-filter-sort-product-by-type',[SellerController::class,'sortFilterIndexByType'])->name('frontend.seller.sort_product_filter_by_type');

//product
Route::get('/product/{slug}',[ProductController::class,'show'])->name('frontend.item.show');
Route::post('/item-details-for-get-modal',[ProductController::class,'show_in_modal'])->name('frontend.item.show_in_modal');
Route::get('/item/reviews/get-data',[ProductController::class,'getReviewByPage'])->name('frontend.product.reviews.get-data');
Route::get('/giftcard/reviews/get-data',[GiftCardController::class,'getReviewByPage'])->name('frontend.giftcard.reviews.get-data');




//merchant register
Route::get('/merchant-register-step-1',[MerchantRegisterController::class,'showRegisterFormStepFirst'])->name('frontend.merchant-register-step-first');
Route::get('/merchant-register-step-2/{id}',[MerchantRegisterController::class,'showRegisterForm'])->name('frontend.merchant-register');
Route::get('/merchant-register-step-3',[MerchantRegisterController::class,'showRegisterForm2'])->name('frontend.merchant-register-subscription-type');
Route::post('/merchant-register',[MerchantRegisterController::class,'register'])->name('frontend.merchant.store');
Route::get('/user-email-verify',[WelcomeController::class,'emailVerify'])->name('frontend.mail-verify');
Route::get('/verify',[\App\Http\Controllers\Auth\EmailVerificationController::class,'emailVerify'])->name('frontend.mail-verify-link');
Route::post('/resend-link',[\App\Http\Controllers\Auth\EmailVerificationController::class,'resendMail'])->name('frontend.resend-link');

//flash deal
Route::get('/flash-deal/{slug}',[FlashDealController::class,'show'])->name('frontend.flash-deal');
Route::get('/flash-deal/{slug}/fetch-data',[FlashDealController::class,'fetchData'])->name('frontend.flash-deal.fetch-data');

Route::get('/shopping-recent-viewed',[WelcomeController::class,'shopping_from_recent_viewed'])->name('frontend.shopping_from_recent_viewed');


// new user zone
Route::get('/new-user-zone/{slug}',[NewUserZoneController::class,'show'])->name('frontend.new-user-zone');
Route::get('/new-user-zone/{slug}/fetch-product-data',[NewUserZoneController::class,'fetchProductData'])->name('frontend.new-user-zone.fetch-product-data');
Route::get('/new-user-zone/{slug}/fetch-category-data',[NewUserZoneController::class,'fetchCategoryData'])->name('frontend.new-user-zone.fetch-category-data');
Route::get('/new-user-zone/{slug}/fetch-coupon-category-data',[NewUserZoneController::class,'fetchCouponCategoryData'])->name('frontend.new-user-zone.fetch-coupon-category-data');
Route::get('/new-user-zone/{slug}/fetch-all-category-data',[NewUserZoneController::class,'fetchAllCategoryData'])->name('frontend.new-user-zone.fetch-all-category-data');
Route::get('/new-user-zone/{slug}/fetch-all-coupon-category-data',[NewUserZoneController::class,'fetchAllCouponCategoryData'])->name('frontend.new-user-zone.fetch-all-coupon-category-data');

Route::post('/new-user-zone/{slug}/coupon-store',[NewUserZoneController::class,'couponStore'])->name('frontend.new-user-zone.coupon-store');


//gift cards
Route::get('/gift-cards',[GiftCardController::class,'index'])->name('frontend.gift-card.index');
Route::get('/gift-cards/fetch-data',[GiftCardController::class,'fetchData'])->name('frontend.gift-card.fetch-data');
Route::get('/gift-cards/fetch-data-by-filter',[GiftCardController::class,'fetchDataByFilter'])->name('frontend.gift-card.fetch-data-by-filter');
Route::get('/gift-cards/{slug}',[GiftCardController::class,'show'])->name('frontend.gift-card.show');
Route::post('/gift-cards/filter-by-type',[GiftCardController::class,'filterByType'])->name('frontend.gift-card.filter_by_type');
Route::get('/gift-cards/filter/page-by-type',[GiftCardController::class,'filterPaginateDataByType'])->name('frontend.gift-card.filter_page_by_type');

Route::group(['middleware' => ['auth','customer']], function(){
    Route::get('/purchased-gift-cards',[GiftCardController::class,'purchased_gift_card'])->name('frontend.purchased-gift-card');
    Route::post('/purchased-gift-cards-redeem',[GiftCardController::class,'gift_card_redeem'])->name('frontend.gift_card_redeem');
    Route::post('/wallet-recharge-via-gift-cards',[GiftCardController::class,'recharge_via_gift_card'])->name('frontend.wallet.recharge_via_gift_card');

    Route::get('digital-products', [OrderController::class,'digital_product_index'])->name('frontend.digital_product');
    //support ticket
    Route::get('/support-ticket',[SupportTicketController::class,'index'])->name('frontend.support-ticket.index');
    Route::get('/support-ticket/paginate',[SupportTicketController::class,'dataWithPaginate'])->name('frontend.support-ticket.paginate');
    Route::get('/support-ticket/create',[SupportTicketController::class,'create'])->name('frontend.support-ticket.create');
    Route::get('/support-ticket/{id}/show',[SupportTicketController::class,'show'])->name('frontend.support-ticket.show');
    Route::post('/support-ticket/store',[SupportTicketController::class,'store'])->name('frontend.support-ticket.store')->middleware('prohibited_demo_mode');;
});



//social login
Route::get('login/{provider}', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback',[App\Http\Controllers\Auth\LoginController::class,'handleProviderCallback']);
Route::post('social-login',[App\Http\Controllers\Auth\LoginController::class,'social_login'])->name('social.login');
Route::post('social-connect',[App\Http\Controllers\Auth\LoginController::class,'social_connect'])->name('social.connect');
Route::post('social-delete/{providerId}',[App\Http\Controllers\Auth\LoginController::class,'social_delete'])->name('social.delete');

//subscription route
Route::post('/subscription/store',[WelcomeController::class,'subscription'])->name('subscription.store');
Route::post('/contact/store',[WelcomeController::class,'contactForm'])->name('contact.store');

//staff
 Route::group(['middleware' => ['auth','admin']], function(){

     Route::middleware('permission')->prefix('hr')->group(function(){
        Route::resource('staffs', '\App\Http\Controllers\StaffController');
        Route::post('/staff-status-update',[StaffController::class,'status_update'])->name('staffs.update_active_status')->middleware('prohibited_demo_mode');
        Route::get('/staff/view/{id}', [StaffController::class,'show'])->name('staffs.view');
        Route::get('/staff/destroy/{id}',[StaffController::class,'destroy'])->name('staffs.destroy')->middleware('prohibited_demo_mode');
     });

    Route::post('/staff-document/store', [StaffController::class,'document_store'])->name('staff_document.store')->middleware('prohibited_demo_mode');
    Route::get('/staff-document/destroy/{id}', [StaffController::class,'document_destroy'])->name('staff_document.destroy')->middleware('prohibited_demo_mode');
    Route::get('/profile-view', [StaffController::class,'profile_view'])->name('profile_view');
    Route::post('/profile-edit', [StaffController::class,'profile_edit'])->name('profile_edit_modal');
    Route::post('/profile-update/{id}', [StaffController::class,'profile_update'])->name('profile.update')->middleware('prohibited_demo_mode');
    Route::post('/staff-profile/img-delete', [StaffController::class,'profileImgDelete'])->name('staff.img.delete')->middleware('prohibited_demo_mode');

 });

 //for profile
 Route::group(['middleware' => ['auth','customer'],'prefix' => 'profile'], function () {

     Route::get('/mark-as-read', [NotificationController::class, 'mark_as_read'])->name('frontend.mark_as_read');
     Route::get('/notifications', [NotificationController::class, 'notifications'])->name('frontend.notifications');
     Route::get('/notificationsData', [NotificationController::class, 'notificationsData'])->name('frontend.notificationsData');
     Route::get('/notification_setting', [NotificationController::class, 'notification_setting'])->name('frontend.notification_setting');
     Route::post('/notification_setting/{id}', [NotificationController::class, 'notification_setting_update'])->name('frontend.notification_setting.update')->middleware('prohibited_demo_mode');

     Route::get('/', [ProfileController::class, 'index'])->name('frontend.customer_profile');
     Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('frontend.dashboard');
     Route::get('/coupons', [CouponController::class, 'index'])->name('customer_panel.coupon');
     Route::post('/coupons/store', [CouponController::class, 'store'])->name('frontend.profile.coupon.store')->middleware('prohibited_demo_mode');
     Route::post('/coupons/delete', [CouponController::class, 'destroy'])->name('frontend.profile.coupon.delete')->middleware('prohibited_demo_mode');
     Route::get('/orders', [ProfileController::class, 'order']);
     Route::get('/refunds', [ProfileController::class, 'refund']);
     Route::get('/referral', [ReferralController::class, 'referral'])->name('customer_panel.referral');
     Route::get('/product-review', [ProductReviewController::class, 'index']);
     Route::post('/product-review', [ProductReviewController::class, 'store'])->name('frontend.profile.review.store');
 });

 //for summernote image upload
 Route::post('summer-note-file-upload', [UploadFileController::class, 'upload_image'])->name('summerNoteFileUpload');


 Route::fallback(function($slug){
     $pageData = DynamicPage::where('is_static', 0)->where('status', 1)->where('slug', $slug)->first();
     if($pageData)
     {
         if($pageData->module == 'Lead' && isModuleActive('Lead') ){
             return view('lead::index',compact('pageData'));
         }else{
             return view(theme('pages.dynamic_page'),compact('pageData'));
         }
     }else{
         return abort(404);
     }
 });
