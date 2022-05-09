<?php
namespace Modules\Setup\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Setup\Repositories\TagRepository;

class TagService
{
    protected $tagRepository;

    public function __construct(TagRepository  $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAll()
    {
        return $this->tagRepository->getAll();
    }

    public function save($data)
    {
        return $this->tagRepository->create($data);
    }

    public function update($data, $id)
    {
        return $this->tagRepository->update($data, $id);
    }

    public function findById($id)
    {
        return $this->tagRepository->find($id);
    }

    public function delete($id)
    {
        return $this->tagRepository->delete($id);
    }
    public function getTagBySentence($sentence)
    {
        return $this->tagRepository->getTagBySentence($sentence);
    }
}
