<?php

namespace SpondonIt\AmazCartService\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SpondonIt\AmazCartService\Repositories\InstallRepository;
use SpondonIt\Service\Repositories\InstallRepository as ServiceRepository;
use SpondonIt\AmazCartService\Requests\UserRequest;
use Illuminate\Support\Facades\Storage;

class InstallController extends Controller{
    protected $repo, $request, $service_repo;

    public function __construct(
        InstallRepository $repo, 
        Request $request,
        ServiceRepository $service_repo
    )
    {
        $this->repo = $repo;
        $this->request = $request;
        $this->service_repo = $service_repo;
    }

    public function index(){
        
        $this->service_repo->checkInstallation();
        return view('amazcart::install.welcome');
    }


    public function user(){
        $ac = Storage::exists('.temp_app_installed') ? Storage::get('.temp_app_installed') : null;

        if(!$this->service_repo->checkDatabaseConnection() || !$ac){
            abort(404);
        }
       
		return view('amazcart::install.user');
    }

    public function post_user(UserRequest $request){
       try{
            $this->service_repo->install($request->all());
       } catch(\Exception $e){
            return response()->json(['message' =>$e->getMessage()]);
       }
         
        $this->repo->install($request->all());
		return response()->json(['message' => __('amazcart::install.done_msg'), 'goto' => route('service.done')]);
    }


}
