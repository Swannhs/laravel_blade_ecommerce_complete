<?php
namespace Modules\Setup\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Setup\Repositories\IntroPrefixRepository;

class IntroPrefixService
{
    protected $introPrefixRepository;

    public function __construct(IntroPrefixRepository  $introPrefixRepository)
    {
        $this->introPrefixRepository = $introPrefixRepository;
    }

    public function getAll()
    {
        return $this->introPrefixRepository->getAll();
    }

    public function create($data)
    {
        return $this->introPrefixRepository->create($data);
    }

    public function update($data, $id)
    {
        return $this->introPrefixRepository->update($data, $id);
    }

    public function findById($id)
    {
        return $this->introPrefixRepository->find($id);
    }

    public function delete($id)
    {
        return $this->introPrefixRepository->delete($id);
    }
}
