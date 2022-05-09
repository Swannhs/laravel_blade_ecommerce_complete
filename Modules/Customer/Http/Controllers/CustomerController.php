<?php

namespace Modules\Customer\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Customer\Http\Requests\ProfileRequest;
use Modules\Customer\Http\Requests\CreateAddressRequest;
use Modules\Customer\Entities\CustomerAddress;
use Modules\Customer\Rules\MatchOldPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\ImageStore;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Modules\Customer\Services\CustomerService;
use App\Repositories\UserRepository;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Setup\Entities\Country;
use Exception;
use Illuminate\Validation\Rule;
use Modules\UserActivityLog\Traits\LogActivity;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    use ImageStore;
    protected $customerRepository;

    public function __construct(CustomerService  $customerService)
    {
        $this->middleware(['auth','maintenance_mode']);
        $this->middleware(['prohibited_demo_mode'])->only('updatePassword');
        $this->customerService = $customerService;
    }

    public function customer_index()
    {
        $data['customers'] = $this->customerService->getAll();
        return view('customer::customers.index', $data);
    }

    public function customer_index_get_data(){
        if(isset($_GET['table'])){
            $table = $_GET['table'];
            if($table == 'active_customer'){
                $customer = $this->customerService->getAll()->where('is_active',1);
            }
            elseif($table == 'inactive_customer'){
                $customer = $this->customerService->getAll()->where('is_active', 0);
            }elseif($table == 'all_customer'){
                $customer = $this->customerService->getAll();
            }

            return DataTables::of($customer)
            ->addIndexColumn()
            ->addColumn('avatar', function($customer){
                return view('customer::customers.components._avatar_td',compact('customer'));
            })

            ->addColumn('status', function($customer){
                return view('customer::customers.components._status_td',compact('customer'));

            })
            ->addColumn('wallet_balance', function($customer){
                return single_price($customer->CustomerCurrentWalletAmounts);
            })

            ->addColumn('orders', function($customer){
                return count($customer->orders);
            })

            ->addColumn('action',function($customer){
                return view('customer::customers.components._action_td',compact('customer'));
            })
            ->rawColumns(['avatar','status','action'])
            ->make(true);
        }else{
            return [];
        }
    }


    public function profile(ProfileRequest $request)
    {
         try {
             $customer_id=auth()->user()->id;
             $address_type=$request['address_type'];
             $match_data=['customer_id'=> $customer_id,'address_type' => $address_type];
             $form_data=[
                'name' => $request['name'],
                'address_one'=> $request['address_one'],
                'address_two' => $request['address_two'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'city' => $request['city'],
                'state' => $request['state'],
                'country' => $request['country'],
                'postal_code' => $request['postal_code']
             ];
             $data=CustomerAddress::updateOrCreate($match_data,$form_data);
             LogActivity::successLog('profile update');
             return response()->json($data);

         } catch (Exception $e) {
             LogActivity::errorLog($e->getMessage());
             Toastr::error(__('common.error_message'));
            return back();
         }
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => 'required|min:8',
            'new_password_confirmation' => 'same:new_password',
        ]);
        try {
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
            LogActivity::successLog('customer password update');
            return response()->json(__('common.updated_successfully'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return back();
        }
    }

    public function create(){
        return view('customer::customers.create');
    }

    public function store(Request $request){
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'nullable|max:255',
            'password' => 'required|confirmed|min:8',
            'referral_code' => ['sometimes', 'nullable', Rule::exists('referral_codes', 'referral_code')->where('status', 1)],
            'status' => 'required'
        ]);

        try{
            $this->customerService->store($request->except('_token'));
            Toastr::success(__('common.created_successfully'), __('common.success'));
            LogActivity::successLog('Customer Created Successfully.');
            return redirect()->route('cusotmer.list_active');
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function edit($id){
        $customer = $this->customerService->find($id);
        return view('customer::customers.edit', compact('customer'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'nullable|max:255',
            'password' => 'sometimes|nullable|confirmed|min:8',
            'status' => 'required'
        ]);
        try{
            $this->customerService->update($request->except('_token'), $id);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Customer Updated Successfully.');
            return redirect()->route('cusotmer.list_active');
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function destroy(Request $request, $id){

        $result = $this->customerService->destroy($id);
            if($result === true){
                Toastr::success(__('common.deleted_successfully'), __('common.success'));
            }else{
                Toastr::warning(__('hr.deleted_not_possible_for_this_customer'), __('common.warning'));
            }
            return redirect()->route('cusotmer.list_active');
        try{
            $result = $this->customerService->destroy($id);
            if($result === true){
                Toastr::success(__('common.deleted_successfully'), __('common.success'));
            }else{
                Toastr::warning(__('hr.deleted_not_possible_for_this_customer'), __('common.warning'));
            }
            return redirect()->route('cusotmer.list_active');


        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function show($id)
    {
        $data['customer'] = $this->customerService->find($id);
        return view('customer::customers.show_details', $data);
    }

    public function getOrders($id){
        $customer = $this->customerService->find($id);
        $order = $customer->orders;

        return DataTables::of($order)
            ->addIndexColumn()
            ->addColumn('date', function($order){
                return date(app('general_setting')->dateFormat->format, strtotime($order->created_at));
            })
            ->addColumn('number_of_product',function($order){
                return  $order->packages->sum('number_of_product');

            })
            ->addColumn('total_amount',function($order){
                return  single_price($order->grand_total);

            })
            ->addColumn('order_status', function($order){
                return view('customer::customers.components._show_order_status_td',compact('order'));

            })
            ->addColumn('is_paid', function($order){
                return view('customer::customers.components._show_order_is_paid_td',compact('order'));
            })

            ->addColumn('action',function($order){
                return view('customer::customers.components._show_order_action_td',compact('order'));
            })
            ->rawColumns(['order_status','is_paid','action'])
            ->make(true);
    }

    public function getWalletHistory($id){
        $customer = $this->customerService->find($id);
        $transaction = $customer->wallet_balances;
        return DataTables::of($transaction)
            ->addIndexColumn()
            ->addColumn('date', function($transaction){
                return date(app('general_setting')->dateFormat->format, strtotime($transaction->created_at));
            })
            ->addColumn('user',function($transaction){
                return  $transaction->user->first_name;

            })
            ->addColumn('amount',function($transaction){
                return  single_price($transaction->amount);

            })
            ->addColumn('payment_method', function($transaction){
                return $transaction->GatewayName;

            })
            ->addColumn('approval', function($transaction){
                return view('customer::customers.components._wallet_approval_td',compact('transaction'));
            })
            ->rawColumns(['approval'])
            ->make(true);
    }


    public function updateInfo(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'email' => 'required|unique:users,email,'.auth()->user()->id,
            'avatar' => 'nullable|mimes:jpeg,jpg,png,bmp',
            'phone' => 'nullable|unique:users,username,'.auth()->id()
        ]);

        try {
            $user=User::findOrFail(auth()->user()->id);
            $data=[
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'username'      => $request->phone,
                'date_of_birth' => $request->date_of_birth?date('Y-m-d',strtotime($request->date_of_birth)):null,
                'description'  => $request->description
             ];
             $file = $request->file('avatar');
             if ($request->hasFile('avatar')) {
                 if ($user->avatar) {
                     if (File::exists($user->avatar)) {
                          File::delete($user->avatar);
                      }
                 }
                 $data['avatar']=$this->saveImage($file,165,165);
             }

            $user->update($data);
            LogActivity::successLog('update info');
            return response()->json($user);

        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }

    }


    public function storeAddress(CreateAddressRequest $request)
    {
        try {

            $data=[
                'customer_id'=>auth()->user()->id,
                'name'=>$request->name,
                'email'=>$request->email,
                'address'=>$request->address,
                'phone'=>$request->phone,
                'city'=>$request->city,
                'state'=>$request->state,
                'country'=>$request->country,
                'postal_code'=>$request->postal_code
            ];
            $customer=CustomerAddress::create($data);
            $list=CustomerAddress::where('customer_id',$customer->customer_id)->get();
            if(count($list)<=1){
                $setDefaltData=CustomerAddress::find($customer->id);
                $setDefaltData->is_shipping_default=1;
                $setDefaltData->is_billing_default=1;
                $setDefaltData->save();
            }

            LogActivity::successLog('address added');
            return  $this->loadTableData();

        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return back();

        }

    }

    public function updateAddress(CreateAddressRequest $request){


        try {
            $customer=CustomerAddress::findOrFail($request->address_id);
            $data=[
                'name'=>$request->name,
                'email'=>$request->email,
                'address'=>$request->address,
                'phone'=>$request->phone,
                'city'=>$request->city,
                'state'=>$request->state,
                'country'=>$request->country,
                'postal_code'=>$request->postal_code
            ];
            $customer->update($data);
            LogActivity::successLog('update address');
            return  $this->loadTableData();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            Toastr::error(__('common.error_message'));
            return back();
        }
    }

    public function setDefaultShipping(Request $request)
    {
       CustomerAddress::where('customer_id',$request->c_id)->update(['is_shipping_default'=> 0]);
       $customer=CustomerAddress::find($request->c_list_id);
       $customer->is_shipping_default=1;
       $customer->save();
       LogActivity::successLog('set default shipping.');
       return  $this->loadTableData();
    }


    public function setDefaultBilling(Request $request)
    {
       CustomerAddress::where('customer_id',$request->c_id)->update(['is_billing_default'=> 0]);
       $customer=CustomerAddress::find($request->c_list_id);
       $customer->is_billing_default = 1 ;
       $customer->save();
       LogActivity::successLog('set default billing.');
       return  $this->loadTableData();
    }

    public function editAddress($c_id){
        try {
            $address=CustomerAddress::findOrFail($c_id);
            $countries = Country::where('status', 1)->orderBy('name')->get();
            if (auth()->user()->role->type != 'customer') {
                return view('backEnd.pages.customer_data._edit_address_form',compact('address', 'countries'));
            }
            else {
                return view(theme('pages.profile.partials._edit_form'),compact('address', 'countries'));
            }

        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function deleteAddress(Request $request){
        try{
            $addressExist = Order::where('customer_id',auth()->user()->id)->where('customer_shipping_address', $request->id)->orWhere('customer_billing_address', $request->id)->first();
            if (!$addressExist) {
                $customer_address = CustomerAddress::where('id',$request->id)->where('customer_id', auth()->user()->id)->first();
                if($customer_address->is_shipping_default == 1 || $customer_address->is_billing_default == 1){
                    return 'is_default';
                }
                $customer_address->delete();
                LogActivity::successLog('address deleted');
                return $this->loadTableData();
            }else{
                return 'is_used';
            }

        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    private function loadTableData()
    {
        try {
            $addressList=CustomerAddress::where('customer_id',auth()->user()->id)->get();
            return response()->json([
                'addressList' =>  (auth()->user()->role->type != 'customer') ?(string)view('backEnd.pages.customer_data._table',compact('addressList')) : (string)view(theme('pages.profile.partials._table'),compact('addressList')),
                'addressListForShipping' =>  (auth()->user()->role->type != 'customer') ?(string)view('backEnd.pages.customer_data._shipping_address',compact('addressList')) : (string)view(theme('pages.profile.partials._shipping'), compact('addressList')),
                'addressListForBilling' =>  (auth()->user()->role->type != 'customer') ?(string)view('backEnd.pages.customer_data._billing_address',compact('addressList')) : (string)view(theme('pages.profile.partials._billing'), compact('addressList')),
            ]);

        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function update_active_status(Request $request)
    {
        try {
            $userRepo = new UserRepository;
            $userRepo->statusUpdate($request->all());
            LogActivity::successLog('customer update active status');
            return 1;
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }
}
