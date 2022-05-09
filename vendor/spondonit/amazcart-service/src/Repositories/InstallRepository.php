<?php

namespace SpondonIt\AmazCartService\Repositories;
ini_set('max_execution_time', -1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Schema;
use Modules\Setting\Model\GeneralSetting;
use SpondonIt\Service\Repositories\InstallRepository as ServiceInstallRepository;

class InstallRepository {

    protected $installRepository;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(ServiceInstallRepository $installRepository) {
        $this->installRepository = $installRepository;
    }



    /**
     * Install the script
     */
    public function install($params) {

        try{
            $admin = $this->makeAdmin($params);
           
            $this->installRepository->seed(gbv($params, 'seed'));
            $this->postInstallScript($admin, $params);

            Artisan::call('key:generate', ['--force' => true]);

            envu([
                'APP_ENV' => 'production',
                'APP_DEBUG'     =>  'false',
            ]);



        } catch(\Exception $e){

            Storage::delete(['.user_email', '.user_pass']);

            throw ValidationException::withMessages(['message' => $e->getMessage()]);

        }
    }

    public function postInstallScript($admin, $params){
        // Update general setting
        $settings_model_name = config('spondonit.settings_model');
        $settings_model = new $settings_model_name;
        $settings = $settings_model->find(1);
        $settings->system_activated_date = date('Y-m-d');
        $settings->system_domain = app_url();
        $settings->save();
    }

    /**
     * Insert default admin details
     */
    public function makeAdmin($params) {
        try{
            $user_model_name = config('spondonit.user_model');
            $user_class = new $user_model_name;
            $user = $user_class->find(1);
            if(!$user){
               $user = new $user_model_name;
            }
            $user->first_name = 'Super';
            $user->last_name = 'admin';
            $user->email = gv($params, 'email');
            if(Schema::hasColumn('users', 'role_id')){
                $user->role_id = 1;
            }
            if(\Illuminate\Support\Facades\Config::get('app.app_sync')){
                $user->password = bcrypt(12345678);

            }else{
                $user->password = bcrypt(gv($params, 'password', 'abcd1234'));
            }

            $user->save();
        } catch(\Exception $e){
            $this->installRepository->rollbackDb();
            throw ValidationException::withMessages(['message' => $e->getMessage()]);
        }


    }

}
