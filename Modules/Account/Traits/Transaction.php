<?php

namespace Modules\Account\Traits;

trait Transaction
{
    public function makeTransaction($title,$type,$method,$come_from,$description,$class,$amount,$date,$creator)
    {
        \Modules\Account\Entities\Transaction::create([
            'title' => $title,
            'type' => $type,
            'payment_method' => $method,
            'come_from' => $come_from,
            'description' => $description,
            'morphable_id' => $class->id,
            'morphable_type' => get_class($class),
            'amount' => $amount,
            'transaction_date' => $date,
            'created_by' => $creator,
        ]);
    }
}
