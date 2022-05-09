<?php

namespace Modules\Attendance\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Attendance\Repositories\HolidayRepositoryInterface;
use Modules\UserActivityLog\Traits\LogActivity;

class HolidayController extends Controller
{
    public $holidayRepository;

    public function __construct(HolidayRepositoryInterface $holidayRepository)
    {
        $this->holidayRepository = $holidayRepository;
        $this->middleware('maintenance_mode');

        $this->middleware('prohibited_demo_mode')->only('store');
    }
    public function index()
    {
         $holidays = $this->holidayRepository->year(null);
        return view('attendance::holiday_setup.index',compact('holidays'));
    }

    public function create()
    {
        return view('attendance::create');
    }

    public function store(Request $request)
    {

        session()->put('holidays',$request->except('_token'));
        $request->validate([
            'holiday_name' => 'required',
            'type' => 'required',
            'date' => 'required_if:type,==,0',
            'start_date' => 'required_if:type,==,1',
            'end_date' => 'required_if:type,==,1',
        ]);


        DB::beginTransaction();

        $this->holidayRepository->create($request->except('_token'));
        try {
            DB::commit();
            session()->forget('holidays');
            LogActivity::successLog(__('hr.holiday_saved_successfully'));
            Toastr::success(__('hr.holiday_saved_successfully'), __('common.success'));
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }

    }

    public function show($id)
    {
        return view('attendance::show');
    }

    public function edit($id)
    {
        return view('attendance::edit');
    }

    public function addRow(Request $request)
    {
        $year = $request->year ?? null;
        $holidays = $this->holidayRepository->year($year);
        if ($year)
            return view('attendance::holiday_setup.row',compact('year','holidays'));
        else
            return view('attendance::holiday_setup.row',compact('year','holidays'));
    }

    public function getLastYearData($year)
    {
        DB::beginTransaction();
        try {
            $holidays = $this->holidayRepository->copyYear($year);
            if($holidays == 1){
                session()->forget('holidays');
                DB::commit();
                Toastr::success(__('hr.holiday_saved_successfully'), __('common.success'));
                return back();
            }
            Toastr::warning(Carbon::create($year)->subYears(1)->year.' '.__('hr.year_holiday_not_found'), __('common.warning'));
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }
}
