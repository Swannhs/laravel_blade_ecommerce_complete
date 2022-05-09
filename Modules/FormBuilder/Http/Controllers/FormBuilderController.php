<?php

namespace Modules\FormBuilder\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Exception;
use Modules\FormBuilder\Entities\CustomForm;
use Modules\FormBuilder\Repositories\FormBuilderRepositories;
use Modules\FrontendCMS\Entities\InQuery;
use Modules\FrontendCMS\Entities\Pricing;
use Modules\FrontendCMS\Repositories\QueryRepository;
use Modules\FrontendCMS\Services\QueryService;

class FormBuilderController extends Controller
{

    protected $formBuilderRepo;

    public function __construct(FormBuilderRepositories $formBuilderRepo)
    {
        $this->formBuilderRepo = $formBuilderRepo;
    }

    public function index()
    {
        try{
            $data['forms'] = $this->formBuilderRepo->all();
            return view('formbuilder::form.index',$data);
        }catch(Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json(['error' => $e->getMessage()],503);
        }

    }

    public function show($id)
    {
        try{
            $data['pricing_plans'] = Pricing::where('status', 1)->get(['name', 'id']);
            $queryRepo = new QueryRepository(new InQuery ());
            $data['QueryList'] = $queryRepo->getAllActive();
            $data['item'] = $this->formBuilderRepo->find($id);
            if($data['item']->form_data){
                $data['form_data'] = json_decode($data['item']->form_data);
            }
            return view('formbuilder::form.show',$data);
        }catch(Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json(['error' => $e->getMessage()],503);
        }

    }

    public function builder($id)
    {
        try{

            $data['row'] = $this->formBuilderRepo->find($id);

            // for contact form
            $queryRepo = new QueryRepository(new InQuery ());
            $queryList = $queryRepo->getAllActive();
            $queryTypeOptions = [];
            foreach ($queryList as $q){
                $queryTypeOptions[] =  [
                    "label" => $q->name,
                    "value" => $q->id
                ];
            }

            //end contact form

            //for seller form
            $pricing_plans = [];
            $pricingPlans = Pricing::where('status', 1)->get(['name', 'id']);
            foreach ($pricingPlans as $p){
                $pricing_plans[] =  [
                    "label" => $p->name,
                    "value" => $p->id,
                    "selected" => session()->get('pricing_id') == $p->id ? true : false,
                ];
            }
            //end seller form

            $data['formData'] = [];
            if($data['row']->form_data == null){
                //affiliate
                if($id == 1){
                    $data['default_Data'] =  [
                        [
                            "className" => "form-control default-field",
                            "label" => "First Name",
                            "placeholder" => "First Name",
                            "name" => "first_name",
                            "required" => true,
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Last Name",
                            "placeholder" => "Last Name",
                            "name" => "last_name",
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Email or Phone",
                            "placeholder" => "Email or Phone",
                            "name" => "email",
                            "type" => "text",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Password",
                            "placeholder" => "Password",
                            "name" => "password",
                            "type" => "text",
                            "subtype" => "password",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Confirm Password",
                            "placeholder" => "Confirm Password",
                            "name" => "password_confirmation",
                            "type" => "text",
                            "subtype" => "password",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "By signing up, you agree to <a href='#' class='term_link_set'>Terms of Service </a> and <a href='#' class='policy_link_set'>Privacy Policy</a>",
                            "name" => "accept",
                            "type" => "checkbox",
                            "inline" => true,
                            "disabledFieldButtons" => ['remove','copy'],
                        ]
                    ];
                    $data['formData'] = json_encode($data['default_Data']);
                }
                //end affiliate
                //customer
                if($id == 2){
                    $data['default_Data'] =  [
                        [
                            "className" => "form-control default-field",
                            "label" => "First Name",
                            "placeholder" => "First Name",
                            "name" => "first_name",
                            "required" => true,
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Last Name",
                            "placeholder" => "Last Name",
                            "name" => "last_name",
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Email or Phone",
                            "placeholder" => "Email or Phone",
                            "name" => "email",
                            "type" => "text",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Referral Code",
                            "placeholder" => "Referral Code",
                            "name" => "referral_code",
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Password",
                            "placeholder" => "Password",
                            "name" => "password",
                            "type" => "text",
                            "subtype" => "password",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Confirm Password",
                            "placeholder" => "Confirm Password",
                            "name" => "password_confirmation",
                            "type" => "text",
                            "subtype" => "password",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "By signing up, you agree to <a href='#' class='term_link_set'>Terms of Service </a> and <a href='#' class='policy_link_set'>Privacy Policy</a>",
                            "name" => "accept",
                            "type" => "checkbox",
                            "inline" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ]
                    ];
                    $data['formData'] = json_encode($data['default_Data']);
                }
                //end customer
                //seller
                if($id == 3){
                    $data['default_Data'] =  [
                        [
                            "className" => "form-control default-field",
                            "label" => "Subscription Type",
                            "name" => "subscription_type",
                            "required" => true,
                            "type" => "select",
                            "values" => $pricing_plans,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Shop Name",
                            "placeholder" => "Shop Name",
                            "name" => "name",
                            "required" => true,
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Email Address",
                            "placeholder" => "Email Address",
                            "name" => "email",
                            "type" => "text",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Phone Number",
                            "placeholder" => "Phone Number",
                            "name" => "phone",
                            "type" => "text",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Password",
                            "placeholder" => "Password",
                            "name" => "password",
                            "type" => "text",
                            "subtype" => "password",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Confirm Password",
                            "placeholder" => "Confirm Password",
                            "name" => "password_confirmation",
                            "type" => "text",
                            "subtype" => "password",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "By signing up, you agree to <a href='#' class='term_link_set'>Terms of Service </a> and <a href='#' class='policy_link_set'>Privacy Policy</a>",
                            "name" => "accept",
                            "type" => "checkbox",
                            "inline" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ]
                    ];
                    $data['formData'] = json_encode($data['default_Data']);
                }
                //end seller
                //contact us
                if($id == 4){
                    $data['default_Data'] =  [
                        [
                            "className" => "form-control default-field",
                            "label" => "Name",
                            "placeholder" => "Enter Name",
                            "name" => "name",
                            "required" => true,
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Email Address",
                            "placeholder" => "Email Address",
                            "name" => "email",
                            "subtype" => "email",
                            "required" => true,
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Inquery Type",
                            "name" => "query_type",
                            "required" => true,
                            "type" => "select",
//                            "values" => [
//                                ["label" => "Option 1","value"=>"option-1"],
//                                ["label" => "Option 2","value"=>"option-2"],
//                            ],
                            "values" => $queryTypeOptions,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "Message",
                            "placeholder" => "Write messages",
                            "name" => "message",
                            "required" => true,
                            "type" => "textarea",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],

                    ];
                    $data['formData'] = json_encode($data['default_Data']);
                }
                //end contact us

                //lead
                if($id == 5){
                    $data['default_Data'] =  [];
                    $data['formData'] = json_encode($data['default_Data']);
                }
                //end lead


            }
            else{
                $form_data = json_decode($data['row']->form_data);
                $data['eData'] = [];
                  foreach ($form_data as $row){
                      if(property_exists($row,'className') && strpos($row->className, 'default-field') !== false){
                          $row->disabledFieldButtons = ['remove','edit','copy'];
                      }
                      $data['eData'][]= $row;
                  }
                $data['formData'] = json_encode($data['eData']);
//                  dd($data['formData']);

            }
            return view('formbuilder::form.builder',$data);
        }catch(Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json(['error' => $e->getMessage()],503);
        }

    }

    public function builderUpdate(Request $request)
    {
        try {
            CustomForm::where('id',$request->id)->update([
                'form_data' => $request->formData
            ]);
            return response()->json(['message'=>'Form Create Successfully']);
        } catch (\Throwable $th) {

            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
