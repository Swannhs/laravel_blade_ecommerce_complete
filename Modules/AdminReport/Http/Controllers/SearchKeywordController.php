<?php

namespace Modules\AdminReport\Http\Controllers;

use App\Models\SearchTerm;
use Illuminate\Contracts\Support\Renderable;
use Modules\AdminReport\Services\SearchKeywordService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\UserActivityLog\Traits\LogActivity;
use Modules\Visitor\Entities\VisitorHistory;
use Yajra\DataTables\Facades\DataTables;

class SearchKeywordController extends Controller
{
    protected $searchKeywordService;


    public function __construct(SearchKeywordService $searchKeywordService)
    {
        $this->searchKeywordService = $searchKeywordService;
        $this->middleware('maintenance_mode');
    }


    public function index()
    {
        return view('adminreport::user_search_report.index');
    }



    public function get_search_keyword_data()
    {
        $data = $this->searchKeywordService->getKeywords();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('keyword', function ($data) {

                return $data->keyword;
            })
            ->addColumn('number_of_time', function ($data) {
                return $data->count;
            })
            ->addColumn('action', function ($data) {
                return view('adminreport::user_search_report.action', compact('data'));
            })
            ->rawColumns(['action'])
            ->toJson();
    }




    public function destroy($id)
    {
        try {
            $this->searchKeywordService->delete($id);
            Toastr::success(__('common.deleted_successfully'), __('common.success'));
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }



}
