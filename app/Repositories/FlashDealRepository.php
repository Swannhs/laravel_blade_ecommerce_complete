<?php
namespace App\Repositories;

use App\Models\User;
use Modules\Marketing\Entities\FlashDeal;
use Modules\Marketing\Entities\FlashDealProduct;

class FlashDealRepository{

    public function getById($slug){

        return FlashDeal::where('slug',$slug)->firstOrFail();
        

    }
    public function getFlashProducts($id){
        return FlashDealProduct::where('flash_deal_id', $id)->get();
    }

}
