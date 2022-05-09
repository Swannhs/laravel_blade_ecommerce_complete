<?php

namespace Modules\Language\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Lang;
use Modules\Language\Services\LanguageSettingService;
use Modules\Language\Http\Requests\LanguageRequestStore;
use Modules\Language\Http\Requests\LanguageRequestUpdate;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Modules\UserActivityLog\Traits\LogActivity;

class LanguageController extends Controller
{
    protected $languageSettingService;

    public function __construct(LanguageSettingService $languageSettingService)
    {
        $this->middleware('maintenance_mode');
        $this->languageSettingService = $languageSettingService;
    }


    public function index()
    {
        try{
            $data['languages'] = $this->languageSettingService->getAll();
            return view('language::languages.index', $data);

        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }


    public function create()
    {
        return view('language::create');
    }


    public function store(LanguageRequestStore $request)
    {

        try {
            $this->languageSettingService->create($request->except("_token"));
            LogActivity::successLog('Language Added Successfully');
            Toastr::success(__('common.added_successfully'), __('common.success'));
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }


    public function show($id)
    {

        try {
            $language = $this->languageSettingService->findById($id);
            session()->put('locale', $language->code);
            $files = scandir(base_path('resources/lang/default/'));
            $module_files = getVar('module_lang');
            foreach ($module_files as $module => $module_file) {
                if (!isModuleActive($module)){
                    $files = array_diff($files, $module_file);
                }
            }

            return view('language::languages.translate_view', [
                "language" => $language,
                "files" => $files
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function edit(Request $request)
    {
        try {
            $language = $this->languageSettingService->findById($request->id);
            return view('language::languages.edit_modal', [
                "language" => $language
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }


    public function update(LanguageRequestUpdate $request, $id)
    {
        try {
            $language = $this->languageSettingService->update($request->except("_token"), $id);
            LogActivity::successLog('Language Updated Successfully');
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }


    public function destroy($id)
    {
        try {

            if($id < 115){
                Toastr::error(__('common.error_message'), __('common.error'));
                return back();
            }

            $language = $this->languageSettingService->findById($id);
            $users = User::where('lang_code', $language->code)->get();

            if(count($users) > 0){
                foreach($users as $key => $user){
                    $user->lang_code = 'en';
                    $user->save();
                }
            }

            if(app('general_setting')->language_code == $language->code){
                DB::table('general_settings')->select('language_code')->where('id', 1)->update([
                    'language_code' => 'en'
                ]);
            }
            $this->languageSettingService->deleteById($id);

            LogActivity::successLog('Language has been deleted Successfully');
            Toastr::success(__('common.deleted_successfully'), __('common.success'));
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back()->with('message-danger', __('common.error_message'));
        }
    }

    public function update_rtl_status(Request $request)
    {
        try{
            $language = $this->languageSettingService->findById($request->id);
            $language->rtl = $request->status;
            if($language->save()){
                LogActivity::successLog('Language rtl status change Successfully');

                return 1;
            }
            return 0;
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function update_active_status(Request $request)
    {

        try{
            $language = $this->languageSettingService->findById($request->id);

            $language->status = $request->status;
            $language->save();
            LogActivity::successLog('Language active status change Successfully');

            $users = User::where('lang_code', $language->code)->get();

            if(count($users) > 0 && $request->status == 0){
                foreach($users as $key => $user){
                    $user->update([
                        'lang_code' => 'en'
                    ]);
                }
            }
            if(app('general_setting')->language_code == $language->code && $request-> status == 0){
                $setting = DB::table('general_settings')->select('language_code')->where('id', 1)->update([
                    'language_code' => 'en'
                ]);
            }

            return 1;

        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }

    }

    public function key_value_store(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'translatable_file_name' => 'required',
            'key' => 'required',
        ]);


        try{
            $language = $this->languageSettingService->findById($request->id);

            if (!file_exists(base_path('resources/lang/'.$language->code))) {
                mkdir(base_path('resources/lang/'.$language->code));
            }
            if (file_exists(base_path('resources/lang/'.$language->code.'/'.$request->translatable_file_name))) {
                file_put_contents(base_path('resources/lang/'.$language->code.'/'.$request->translatable_file_name), '');
            }
            file_put_contents(base_path('resources/lang/'.$language->code.'/'.$request->translatable_file_name), '<?php return ' . var_export($request->key, true) . ';');
            

            LogActivity::successLog($language->name. '- translated.');
            Toastr::success(__('common.updated_successfully'), __('common.success'));


            LogActivity::successLog('Language key value store Successfully');
            return back();

        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function changeLanguage(Request $request)
    {
        try {
            session()->put('locale', $request->code);

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

    public function get_translate_file(Request $request)
    {
        try{
            $language = $this->languageSettingService->findById($request->id);
            $file_name = explode('.', $request->file_name);
            $languages = Lang::get($file_name[0]);
            $translatable_file_name = $request->file_name;

            if(file_exists(base_path('resources/lang/'.$language->code.'/'.$request->file_name)))
            {
                $url = base_path('resources/lang/'.$language->code.'/'.$request->file_name);
                $languages = include  "{$url}";
                return view('language::modals.translate_modal', [
                    "languages" => $languages,
                    "language" => $language,
                    "translatable_file_name" => $translatable_file_name
                ]);
            }


            $file1 = base_path('resources/lang/default/'.$request->file_name);
            if (!file_exists(base_path('resources/lang/'.$language->code))) {
                mkdir(base_path('resources/lang/'.$language->code));
            }
            if (!file_exists(base_path('resources/lang/'.$language->code.'/'.$request->file_name))) {
                copy($file1,base_path('resources/lang/'.$language->code.'/'.$request->file_name));
            }



            $file2 = base_path('resources/lang/'.$language->code.'/'.$request->file_name);
            // Count the number of lines on file
            $no_of_lines_file_1 = count(file($file1));
            $no_of_lines_file_2 = count(file($file2));

            if ($no_of_lines_file_1 > $no_of_lines_file_2) {
                $file_contents = file_get_contents($file2);
                $file_contents = str_replace("\n];"," ",$file_contents);
                file_put_contents($file2,$file_contents);
                $i = $no_of_lines_file_2 - 1;
                $lines = file($file1);
                foreach ($lines as $line) {
                  $fp = fopen($file2, 'a');
                  if ($i < $no_of_lines_file_1) {
                      fwrite($fp, $lines[$i]);
                      $i++;
                  }
                  fclose($fp);
                }
            }

            return view('language::modals.translate_modal', [
                "languages" => $languages,
                "language" => $language,
                "translatable_file_name" => $translatable_file_name
            ]);
        }catch (\Exception $e) {

            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }

    }
}
