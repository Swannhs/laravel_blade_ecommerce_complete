<?php

namespace Modules\GiftCard\Repositories;

use App\Models\Cart;
use App\Traits\ImageStore;
use Carbon\Carbon;
use App\Models\OrderProductDetail;
use Maatwebsite\Excel\Facades\Excel;
use Modules\GiftCard\Imports\GiftCardImport;
use Modules\GiftCard\Entities\GiftCard;
use Modules\GiftCard\Entities\GiftCardUse;
use Modules\GiftCard\Entities\GiftCardGalaryImage;
use Modules\Shipping\Entities\ShippingMethod;
use Modules\OrderManage\Repositories\OrderManageRepository;
use App\Traits\SendMail;
use Modules\GiftCard\Entities\GiftCardTag;
use Modules\Setup\Entities\Tag;

class GiftCardRepository
{
    use ImageStore, SendMail;

    public function getAll(){
        return GiftCard::latest();
    }

    public function store($data)
    {
        if(!empty($data['thumbnail_image'])){
            $data['thumbnail_image'] = ImageStore::saveImage($data['thumbnail_image'],165,165);
        }

        $card = GiftCard::create([
            'name' => $data['name'],
            'sku' => $data['sku'],
            'selling_price' => $data['selling_price'],
            'discount' => $data['discount'],
            'discount_type' => $data['discount_type'],
            'start_date' => ($data['start_date']) ? Carbon::parse($data['start_date'])->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
            'end_date' => ($data['end_date']) ? Carbon::parse($data['end_date'])->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
            'thumbnail_image' => $data['thumbnail_image']?$data['thumbnail_image']:null,
            'status' => $data['status'],
            'description' => $data['description'],
            'shipping_id' => 1
        ]);
        $tags = [];
        $tags = explode(',', $data['tags']);

        foreach ($tags as $key => $tag) {
            $tag = Tag::where('name', $tag)->updateOrCreate([
                'name' => $tag
            ]);
            GiftCardTag::create([
                'gift_card_id' => $card->id,
                'tag_id' => $tag->id,
            ]);
        }

        if(!empty($data['galary_image'])){
            foreach($data['galary_image'] as $key => $image){
                $image_name = ImageStore::saveImage($image,400,440);
                GiftCardGalaryImage::create([
                    'image_name' => $image_name,
                    'gift_card_id' => $card->id
                ]);
            }
        }

        return true;


    }

    public function statusChange($data){
        return GiftCard::where('id', $data['id'])->update([
            'status' => $data['status']
        ]);
    }

    public function getById($id){
        return GiftCard::findOrFail($id);
    }

    public function update($data, $id)
    {
        $card = GiftCard::findOrFail($id);
        if(!empty($data['thumbnail_image'])){
            ImageStore::deleteImage($card->thumbnail_image);
            $data['thumbnail_image'] = ImageStore::saveImage($data['thumbnail_image'], 165, 165);
        }
        $card->update([
            'name' => $data['name'],
            'sku' => $data['sku'],
            'selling_price' => $data['selling_price'],
            'discount' => $data['discount'],
            'discount_type' => $data['discount_type'],
            'start_date' => isset($data['start_date']) ? Carbon::parse($data['start_date'])->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
            'end_date' => isset($data['end_date']) ? Carbon::parse($data['end_date'])->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
            'thumbnail_image' => isset($data['thumbnail_image'])?$data['thumbnail_image']:$card->thumbnail_image,
            'status' => $data['status'],
            'description' => $data['description'],
            'shipping_id' => 1
        ]);

        //for tag start
        $tags = [];
        $tags = explode(',', $data['tags']);
        $oldtags = GiftCardTag::where('gift_card_id', $id)->whereHas('tag', function($q)use($tags){
            $q->whereNotIn('name',$tags);
        })->pluck('id');
        GiftCardTag::destroy($oldtags);

        foreach ($tags as $key => $tag) {
            $tag = Tag::where('name', $tag)->updateOrCreate([
                'name' => $tag
            ]);
            GiftCardTag::where('gift_card_id', $card->id)->where('tag_id', $tag->id)->updateOrCreate([
                'gift_card_id' => $card->id,
                'tag_id' => $tag->id,
            ]);
        }
        // for tag end

        if(!empty($data['galary_image'])){

            $images = GiftCardGalaryImage::where('gift_card_id', $id)->get();
            foreach($images as $img){
                ImageStore::deleteImage($img->image_name);
                $img->delete();
            }


            foreach($data['galary_image'] as $key => $image){
                $image_name = ImageStore::saveImage($image,400,440);
                GiftCardGalaryImage::create([
                    'image_name' => $image_name,
                    'gift_card_id' => $card->id
                ]);
            }
        }

        return true;


    }

    public function deleteById($id){
        $card = GiftCard::findOrFail($id);
        $listInCart = Cart::where('product_type','gift_card')->where('product_id', $card->id)->pluck('id')->toArray();
        // Cart::destroy($listInCart);
        $existProduct = OrderProductDetail::where('type', 'gift_card')->where('product_sku_id', $card->id)->first();
        if ($existProduct) {
            return "not_possible";
        }
        foreach($card->galaryImages as $image){
            ImageStore::deleteImage($image->image_name);
            $image->delete();
        }
        ImageStore::deleteImage($card->thumbnail_image);

        $card->delete();
        return 'possible';
    }

    public function getShipping(){
        return ShippingMethod::where('is_active', 1)->get();
    }

    public function send_code_to_mail($data)
    {
        $orderRepo = new OrderManageRepository;
        $order = $orderRepo->findOrderByID($data['order_id']);
        $gift_card = $this->getById($data['gift_card_id']);
        $secret_code = date('ymd-his').'-'.rand(111,999).$order->id.'-'.$gift_card->id.rand(1111,9999);
        try {
            $this->sendGiftCardSecretCodeMail($order, $data['mail'], $gift_card, $secret_code);
            $this->storeGiftCardData($secret_code, $order->id, $gift_card->id, 1, $data['qty']);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function storeGiftCardData($secret_code, $order_id, $gift_card_id, $is_mail_sent, $qty)
    {
        $existGiftCardInfo = GiftCardUse::where('gift_card_id',$gift_card_id)->where('order_id',$order_id)->first();
        if ($existGiftCardInfo == null) {
            GiftCardUse::create([
                'gift_card_id' => $gift_card_id,
                'order_id' => $order_id,
                'qty' => $qty,
                'secret_code' => $secret_code,
                'is_mail_sent' => $is_mail_sent,
                'mail_sent_date' => Carbon::now()->format('Y-m-d')
            ]);
        }else {
            $existGiftCardInfo->update([
                'secret_code' => $secret_code,
                'mail_sent_date' => Carbon::now()->format('Y-m-d')
            ]);
        }
    }

    public function csvUploadCategory($data)
    {
        Excel::import(new GiftCardImport, $data['file']->store('temp'));
    }
}
