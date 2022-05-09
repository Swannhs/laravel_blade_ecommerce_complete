<?php

namespace Modules\FrontendCMS\Repositories;

use App\Traits\ImageStore;
use \Modules\FrontendCMS\Entities\SubscribeContent;

class SubcribeContentRepository
{

    use ImageStore;
    protected $subcribe;

    public function __construct(SubscribeContent $subcribe)
    {
        $this->subcribe = $subcribe;
    }


    public function getAllContent()
    {
        return $this->subcribe->get();
    }

    public function update($data, $id)
    {

        $subcribeContent = SubscribeContent::findOrFail($id);
        if ($data->hasFile('file')) {
            $file = $data->file('file');
            $filename = $this->saveImage($file);
        }else{
            $filename = $subcribeContent->image;
        }
        return $subcribeContent->update([
            'title' => isset($data['title'])?$data['title']:null,
            'subtitle' => isset($data['subtitle'])?$data['subtitle']:null,
            'description' => isset($data['description'])?$data['description']:null,
            'second' => isset($data['second'])?$data['second']:null,
            'status' => (isset($data['status']) && $data['status'] == 1)?1:0,
            'image' => $filename
        ]);
        return 1;
    }
    public function edit($id)
    {
        $subcribe = $this->subcribe->findOrFail($id);
        return $subcribe;
    }
}
