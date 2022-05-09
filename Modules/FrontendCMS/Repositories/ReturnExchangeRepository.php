<?php
namespace Modules\FrontendCMS\Repositories;

use Modules\FrontendCMS\Entities\ReturnExchange;

class ReturnExchangeRepository {

    protected $return;

    public function __construct(ReturnExchange $return){
        $this->return = $return;
    }


    public function getAll()
    {
        return $this->return::firstOrfail();
    }


    public function update($data, $id)
    {   
        return $this->return::where('id',$id)->update([
            'mainTitle' => $data['mainTitle'],
            'returnTitle' => $data['returnTitle'],
            'exchangeTitle' => $data['exchangeTitle'],
            'slug' => $data['slug'],
            'returnDescription' => $data['returnDescription'],
            'exchangeDescription' => $data['exchangeDescription']
        ]);

    }


    public function show($id){
        $return = $this->return->findOrFail($id);
        return $return;
    }

    public function edit($id){
        $return = $this->return->findOrFail($id);
        return $return;
    }
}
