<?php

namespace App\Http\Controllers;

use App\Traits\Notification;
use Illuminate\Http\Request;
use App\Models\StaffDocument;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\UserRepositoryInterface;
use App\Http\Requests\StaffRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\RolePermission\Entities\Role;
use Modules\Setup\Entities\Department;
use Modules\UserActivityLog\Traits\LogActivity;

class StaffController extends Controller
{
    use Notification;

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->middleware(['auth', 'verified','maintenance_mode']);
        $this->middleware('prohibited_demo_mode')->only('store','status_update','destroy','document_store','document_destroy','profile_update','profileImgDelete','update');
        $this->userRepository = $userRepository;

    }

    public function index(Request $request)
    {

        try {
            $staffs = $this->userRepository->all(['user.role','department']);

            return view('backEnd.staffs.index', [
                "staffs" => $staffs,
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }

    }

    public function create()
    {
        $roles = Role::where('id', '>', 1)->where('type','admin')->orWhere('type','staff')->get();
        $departments = Department::where('status', 1)->get();
        return view('backEnd.staffs.create', compact('roles', 'departments'));
    }

    public function store(StaffRequest $request)
    {

        DB::beginTransaction();

        try {
            if ($request->password) {


                try {
                    $staff = $this->userRepository->store($request->except("_token"));
                    DB::commit();
                    LogActivity::successLog(__('hr.staff') .' '. __('common.added_successfully'));
                    Toastr::success(__('common.added_successfully'), __('common.success'));
                    return redirect()->route('staffs.index');

                }catch (\Exception $e) {
                    LogActivity::errorLog($e->getMessage());
                    DB::rollBack();
                    Toastr::error(__('common.error_message'), __('common.error'));
                    return back();
                }
            } else {
                DB::rollBack();
                Toastr::error(__('common.error_message'), __('common.error'));
                return back();
            }
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function show(Request $request)
    {


        try {
            $staffDetails = $this->userRepository->find($request->id);
            $staffDocuments = $this->userRepository->findDocument($request->id);

            return view('backEnd.staffs.viewStaff', [
                "staffDetails" => $staffDetails,
                "staffDocuments" => $staffDocuments

            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function edit($id)
    {
        try {
            $staff = $this->userRepository->find($id);
            $roles = Role::where('id', '>', 1)->where('type','admin')->orWhere('type','staff')->get();
            $departments = Department::where('status', 1)->get();
            return view('backEnd.staffs.edit', [
                "staff" => $staff,
                "roles" => $roles,
                "departments" => $departments
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return $e->getMessage();
        }
    }

    public function update(StaffRequest $request, $id)
    {

        DB::beginTransaction();

        try {
            $staff = $this->userRepository->update($request->except("_token"), $id);

            DB::commit();
            LogActivity::successLog($request->first_name . '- profile has been updated.');
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return redirect()->route('staffs.index');

        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function destroy($id)
    {

        try {
            $staff = $this->userRepository->delete($id);
            LogActivity::successLog('Staff has been destroyed.');
            Toastr::success(__('common.deleted_successfully'), __('common.success'));
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            LogActivity::errorLog($e->getMessage() . ' - Staff has been detected for Role Destroy');
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function status_update(Request $request)
    {
        try {
            $staff = $this->userRepository->statusUpdate($request->except("_token"));
            LogActivity::successLog('User Active Status has been updated.');
            return response()->json([
                'success' => trans('common.updated_successfully')
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => trans('common.error_message')
            ]);
        }
    }

    public function document_store(Request $request)
    {
        try {
            if ($request->file('file') != "" && $request->name != "") {
                $file = $request->file('file');
                $document = 'staff-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('uploads/staff/document/', $document);
                $document = 'uploads/staff/document/' . $document;
                $staffDocument = new StaffDocument();
                $staffDocument->name = $request->name;
                $staffDocument->staff_id = $request->staff_id;
                $staffDocument->documents = $document;
                $staffDocument->save();
            }
            LogActivity::successLog('document store successful.');
            Toastr::success(__('common.uploaded_successfully'), __('common.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function document_destroy($id)
    {
        try {
            $staff = $this->userRepository->deleteStaffDoc($id);
            LogActivity::successLog('Document of Staff has been destroyed.');
            Toastr::success(__('common.deleted_successfully'), __('common.success'));
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - detected for Staff Document Destroy');
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function profile_view()
    {
        try {
            $staffDetails = $this->userRepository->find(Auth::user()->staff->id);
            $leaveDetails = $this->leaveRepository->user_leave_history(Auth::user()->id);
            $total_leave = $this->leaveRepository->total_leave(Auth::user()->id);
            $apply_leave_histories = $this->leaveRepository->user_leave_history(Auth::user()->id);
            $staffDocuments = $this->userRepository->findDocument(Auth::user()->staff->id);
            $loans = $this->applyLoanRepository->staffLoans(Auth::user()->id);
            return view('backEnd.profiles.profile', [
                "staffDetails" => $staffDetails,
                "leaveDetails" => $leaveDetails,
                "total_leave" => $total_leave,
                "staffDocuments" => $staffDocuments,
                'apply_leave_histories' => $apply_leave_histories,
                "loans" => $loans
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function profile_edit(Request $request)
    {
        try {
            $user = $this->userRepository->findUser($request->id);
            return view('backEnd.profiles.editProfile', [
                "user" => $user
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function profile_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.Auth::id(),
            'username' => 'required|unique:users,username,'.Auth::id(),
            'phone' => 'required|unique:staffs,phone,'.Auth::user()->staff->id,
        ]);
        if (Auth::user()->role->type != 'superadmin')
        {
            $request->validate([
                'bank_name' => 'required',
                'bank_branch_name' => 'required',
                'bank_account_name' => 'required',
                'bank_account_no' => 'required',
                'current_address' => 'required',
                'permanent_address' => 'required',
            ]);
        }
        try {
            $this->userRepository->updateProfile($request->except("_token"), $id);
            LogActivity::successLog('Profile has been updated.');
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return back();

        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function profileImgDelete (Request $request){
       return $this->userRepository->staffImgDelete($request->id);
    }
}

