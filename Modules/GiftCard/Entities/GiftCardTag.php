<?php

namespace Modules\GiftCard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Setup\Entities\Tag;

class GiftCardTag extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'gift_card_tag';
    
    public function tag(){
        return $this->belongsTo(Tag::class,'tag_id','id');
    }
    public function giftCard(){
        return $this->belongsTo(GiftCard::class, 'gift_card_id', 'id');
    }
}
