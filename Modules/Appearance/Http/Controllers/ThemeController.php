<?php

namespace Modules\Appearance\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \Modules\Appearance\Services\ThemeService;
use Exception;
use ZipArchive;
use Illuminate\Support\Str;
use \Modules\Appearance\Entities\Theme;
use App\Traits\UploadTheme;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;

class ThemeController extends Controller
{
    use UploadTheme;
    protected $themeService;

    public function __construct(ThemeService $themeService)
    {
        $this->themeService = $themeService;
        $this->middleware('maintenance_mode');
    }

    public function index()
    {
        try {
            $activeTheme = $this->themeService->activeOne();
            $ThemeList = $this->themeService->getAllActive();
            return view('appearance::theme.index', compact('ThemeList', 'activeTheme'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }


    public function create()
    {
        try {
            return view('appearance::theme.components.create');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function active(Request $request)
    {

        try {
            $this->themeService->isActive($request->only('id'), $request->id);
            $notification = array(
                'messege' => 'Theme Change Successfully.',
                'alert-type' => 'success'
            );
            LogActivity::successLog('Theme activated.');
            return redirect(route('appearance.themes.index'))->with($notification);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'themeZip' => 'required|mimes:zip'
        ]);

        try {
            if ($request->hasFile('themeZip')) {

                $dir = 'theme';
                if (!is_dir($dir))
                    mkdir($dir, 0777, true);

                $path = $request->themeZip->store('theme');

                $request->themeZip->getClientOriginalName();

                $zip = new ZipArchive;
                $res = $zip->open(storage_path('app/' . $path));

                $random_dir = Str::random(10);


                $dir = trim($zip->getNameIndex(0), '/');

                if ($res === true) {
                    $zip->extractTo(storage_path('app/temp/' . $random_dir . '/theme'));
                    $zip->close();
                } else {
                    
                }

                $str = @file_get_contents(storage_path('app/temp/') . $random_dir . '/theme/' . $dir . '/config.json', true);


                $json = json_decode($str, true);
                if (!empty($json['files'])) {
                    foreach ($json['files'] as $key => $directory) {
                        if ($key == 'asset_path') {
                            if (!is_dir($directory)) {
                                mkdir(base_path($directory), 0777, true);
                            }
                        }
                        if ($key == 'view_path') {
                            if (!is_dir($directory)) {
                                mkdir(base_path($directory), 0777, true);
                            }
                        }
                    }
                }

                // Create/Replace new files.
                if (!empty($json['files'])) {
                    foreach ($json['files'] as $key => $file) {

                        if ($key == 'asset_path') {
                            $src = base_path('storage/app/temp/' . $random_dir . '/theme' . '/' . $json['folder_path'] . '/asset');
                            $dst = base_path($file);
                            $this->recurse_copy($src, $dst);

                        }
                        if ($key == 'view_path') {
                            $src = base_path('storage/app/temp/' . $random_dir . '/theme' . '/' . $json['folder_path'] . '/view');
                            $dst = base_path($file);
                            $this->recurse_copy($src, $dst);
                        }
                    }
                }

                if (Theme::where('name', '!=', $json['name'])) {
                    Theme::create([
                        'name' => $json['name'],
                        'title' => $json['title'],
                        'image' => $json['image'],
                        'version' => $json['version'],
                        'folder_path' => $json['folder_path'],
                        'live_link' => $json['live_link'],
                        'description' => $json['description'],
                        'is_active' => $json['is_active'],
                        'status' => $json['status'],
                        'tags' => $json['tags']
                    ]);
                }
            }
            if (is_dir('theme') || is_dir('temp')) {

                $this->delete_directory(storage_path('app/theme'));
                $this->delete_directory(storage_path('app/temp'));
            }


            Toastr::success("New Theme Upload Successfully.", 'Success');

            return redirect(route('appearance.themes.index'));
        } catch (Exception $e) {
            if (is_dir('theme') || is_dir('temp')) {

                $this->delete_directory(storage_path('app/theme'));
                $this->delete_directory(storage_path('app/temp'));
            }

            LogActivity::errorLog($e->getMessage());
        }
    }



    public function show($id)
    {
        try {
            $theme = $this->themeService->showById($id);
            return view('appearance::theme.components.show', compact('theme'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }




    public function destroy(Request $request)
    {
        try {
            $this->themeService->delete($request->id);

            LogActivity::successLog('Theme deleted.');
            Toastr::success('Theme Deleted Successfully.', __('common.success'));
            return redirect(route('appearance.themes.index'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }
}
