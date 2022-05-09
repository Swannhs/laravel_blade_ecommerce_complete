<?php

namespace Modules\FrontendCMS\Repositories;

use \Modules\FrontendCMS\Entities\MerchantContent;

class MerchantContentRepository
{

    protected $merchantContent;

    public function __construct(MerchantContent $merchantContent)
    {
        $this->merchantContent = $merchantContent;
    }

    public function getAll(){
        return $this->merchantContent->firstOrFail();
    }

    public function update($data, $id)
    {
        $merchantContent = $this->merchantContent::where('id', $id)->first();
        return $merchantContent->update([
            'mainTitle' => $data['mainTitle'],
            'subTitle' => $data['subTitle'],
            'slug' => $data['slug'],
            'Maindescription' => $data['Maindescription'],
            'pricing' => $data['pricing'],
            'benifitTitle' => $data['benifitTitle'],
            'benifitDescription' => $data['benifitDescription'],
            'howitworkTitle' => $data['howitworkTitle'],
            'howitworkDescription' => $data['howitworkDescription'],
            'pricingTitle' => $data['pricingTitle'],
            'pricingDescription' => $data['pricingDescription'],
            'sellerRegistrationTitle' => $data['sellerRegistrationTitle'],
            'sellerRegistrationDescription' => $data['sellerRegistrationDescription'],
            'queryTitle' => $data['queryTitle'],
            'queryDescription' => $data['queryDescription'],
            'faqTitle' => $data['faqTitle'],
            'faqDescription' => $data['faqDescription'],
            'pricing_id' => $data['pricing_id'],
        ]);
    }

    public function edit($id)
    {
        $merchantContent = $this->merchantContent->findOrFail($id);
        return $merchantContent;
    }
}
