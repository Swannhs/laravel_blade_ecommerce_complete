<?php
namespace Modules\AdminReport\Services;

use Illuminate\Support\Facades\Validator;
use Modules\AdminReport\Repositories\SearchKeywordRepository;
use Illuminate\Support\Arr;

class SearchKeywordService
{
    protected $searchKeywordRepo;

    public function __construct(SearchKeywordRepository $searchKeywordRepo)
    {
        $this->searchKeywordRepo = $searchKeywordRepo;
    }

    public function getKeywords()
    {
        return $this->searchKeywordRepo->getKeywords();
    }

    public function delete($id)
    {
        return $this->searchKeywordRepo->delete($id);
    }

    public function getVisitor()
    {
        return $this->searchKeywordRepo->getVisitor();
    }
}
