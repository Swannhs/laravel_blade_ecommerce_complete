<?php
namespace Modules\FrontendCMS\Repositories;

use \Modules\FrontendCMS\Entities\AboutUs;

class AboutUsRepository {

    protected $aboutus;

    public function __construct(AboutUs $aboutus)
    {
        $this->aboutus = $aboutus;
    }

    public function getAll(){
        return $this->aboutus::firstOrFail();
    }


    public function update($data, $id)
    {
        $aboutus = $this->aboutus::where('id',$id)->first();
        return $aboutus->update([
            'mainTitle' => $data['mainTitle'],
            'subTitle' => $data['subTitle'],
            'mainDescription' => $data['mainDescription'],
            'sec1_image' =>$data['sec1_image'],
            'sec2_image' =>$data['sec2_image'],
            'benifitTitle' => $data['benifitTitle'],
            'benifitDescription' => $data['benifitDescription'],
            'sellingTitle' => $data['sellingTitle'],
            'sellingDescription' => $data['sellingDescription'],
            'price' => $data['price'],
            'slug' => $data['slug']
        ]);

        
    }

    public function edit($id){
        $aboutus = $this->aboutus->findOrFail($id);
        return $aboutus;
    }
}
