<?php

namespace Modules\GeneralSetting\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\GeneralSetting\Repositories\CurrencyRepository;
use Modules\Language\Repositories\LanguageRepository;

/**
* @group General Setting
*
* APIs for General Setting
*/
class GeneralSettingController extends Controller
{

    protected $languageRepo;

    public function __construct(LanguageRepository $languageRepo)
    {
        $this->languageRepo = $languageRepo;
    }

    /**
     * Settings info
     * @response{
     *      "settings": [
     *           {
     *               "site_title": "Amaz cart",
     *               "company_name": "Amaz cart",
     *               "country_name": "BD",
     *               "zip_code": "1200",
     *               "address": "Panthapath",
     *               "phone": "0187595662",
     *               "email": "amazcart@spondonit.com",
     *               "currency_symbol": "$",
     *               "logo": "uploads/settings/6127358234608.png",
     *               "favicon": "uploads/settings/6127304e2f2b6.png",
     *               "currency_code": "USD",
     *               "copyright_text": "Copyright © 2019 - 2020 All rights reserved | This application is made by <a href=\"https://codecanyon.net/user/codethemes\">Codethemes</a>",
     *               "language_code": "en"
     *           }
     *       ],
     *       "msg": "success"
     * }
     */
    public function index(){
        $settings = DB::table('general_settings')->select('site_title', 'company_name','country_name', 'zip_code','address','phone','email','currency_symbol','logo','favicon','currency_code','copyright_text','language_code','country_id','state_id','city_id')->first();
        $currencyRepo = new CurrencyRepository();
        $currencies = $currencyRepo->getActiveAll();
        $languages = $this->languageRepo->getActiveAll();
        $vendorType = 'single';
        if(isModuleActive('MultiVendor')){
            $vendorType = 'multi';
        }

        return response()->json([
            'settings' => $settings,
            'currencies' => $currencies,
            'languages' => $languages,
            'vendorType' => $vendorType,
            'msg' => 'success'
        ]);
    }

    /**
     * Languages
     * @response{
     *      "languages": [
     *           {
     *               "id": 3,
     *               "code": "ar",
     *               "name": "Arabic",
     *               "native": "العربية",
     *               "rtl": 1,
     *               "status": 1,
     *               "json_exist": 0,
     *               "created_at": null,
     *               "updated_at": null
     *           },
     *           {
     *               "id": 5,
     *               "code": "az",
     *               "name": "Azerbaijani",
     *               "native": "Azərbaycanca / آذربايجان",
     *               "rtl": 0,
     *               "status": 1,
     *               "json_exist": 0,
     *               "created_at": null,
     *               "updated_at": "2021-09-08T10:40:27.000000Z"
     *           },
     *           {
     *               "id": 9,
     *               "code": "bn",
     *               "name": "Bengali",
     *               "native": "বাংলা",
     *               "rtl": 0,
     *               "status": 1,
     *               "json_exist": 0,
     *               "created_at": null,
     *               "updated_at": "2021-09-09T11:21:10.000000Z"
     *           },
     *           {
     *               "id": 19,
     *               "code": "en",
     *               "name": "English",
     *               "native": "English",
     *               "rtl": 0,
     *               "status": 1,
     *               "json_exist": 0,
     *               "created_at": null,
     *               "updated_at": "2021-09-09T10:11:04.000000Z"
     *           }
     *       ],
     *       "msg": "success"
     * }
     */

    public function getActiveLanguages(){
        $languages = $this->languageRepo->getActiveAll();
        return response()->json([
            'languages' => $languages,
            'msg' => 'success'
        ]);
    }
}
