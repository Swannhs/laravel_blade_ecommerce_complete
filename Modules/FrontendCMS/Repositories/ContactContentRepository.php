<?php

namespace Modules\FrontendCMS\Repositories;

use \Modules\FrontendCMS\Entities\ContactContent;

class ContactContentRepository
{

    protected $contactContent;

    public function __construct(ContactContent $contactContent)
    {
        $this->contactContent = $contactContent;
    }


    public function all(){
        return $this->contactContent::firstOrfail();
        
    }

    public function update($data, $id)
    {
        $contactContent = $this->contactContent::where('id', $id)->first();
        return $contactContent->update([
            'mainTitle' => $data['mainTitle'],
            'subTitle' => $data['subTitle'],
            'slug' => $data['slug'],
            'email' => $data['email'],
            'description' => $data['description'],
        ]);
    }

    public function edit($id)
    {
        $contactContent = $this->contactContent->findOrFail($id);
        return $contactContent;
    }
}
