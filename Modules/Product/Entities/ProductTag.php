<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Seller\Entities\SellerProduct;
use Modules\Setup\Entities\Tag;

class ProductTag extends Model
{
    use HasFactory;
    protected $table = "product_tag";
    protected $guarded = ['id'];

    public function tag(){
        return $this->belongsTo(Tag::class,'tag_id','id');
    }
    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
