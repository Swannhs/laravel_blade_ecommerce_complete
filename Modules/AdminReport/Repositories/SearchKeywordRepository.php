<?php

namespace Modules\AdminReport\Repositories;
use App\Models\SearchTerm;
use Illuminate\Support\Facades\DB;
use Modules\Visitor\Entities\VisitorHistory;

class SearchKeywordRepository
{
    public function getKeywords()
    {
       return SearchTerm::orderBy('count','desc');
    }

    public function delete($id)
    {
        return SearchTerm::findOrFail($id)->delete($id);
    }

}
