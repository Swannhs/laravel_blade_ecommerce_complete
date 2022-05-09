<?php
namespace Modules\Language\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Language\Repositories\LanguageRepository;

class LanguageSettingService
{
    protected $languagesRepository;

    public function __construct(LanguageRepository $languagesRepository)
    {
        $this->languagesRepository = $languagesRepository;
    }

    public function getAll()
    {
        return $this->languagesRepository->getAll();
    }

    public function create($data)
    {
        return $this->languagesRepository->create($data);
    }

    public function findById($id)
    {
        return $this->languagesRepository->find($id);
    }

    public function update($data, $id)
    {
        return $this->languagesRepository->update($data, $id);
    }

    public function deleteById($id)
    {
        return $this->languagesRepository->delete($id);
    }
}
