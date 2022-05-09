<?php
namespace Modules\UserActivityLog\Traits;

use Request;
use Browser;
use Carbon\Carbon;
use Modules\UserActivityLog\Entities\LogActivity as LogActivityModel;

class LogActivity
{

    public static function addLog($type, $subject)
    {
        $log = [];
    	$log['type'] = $type;
    	$log['subject'] = $subject;
        $log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Browser::browserFamily().'-'.Browser::browserVersion().'-'.Browser::browserEngine().'-'.Browser::platformName().'-'.Browser::deviceModel();
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	LogActivityModel::create($log);
    }

    public static function errorLog($message)
    {
        $type = 0;
        $subject = $message;
        self::addLog($type, $subject);
    }

    public static function loginLog($message)
    {
        $type = 1;
        $subject = $message;
        self::addLoginLog($type, $subject);
    }

    public static function logoutLog($user_id, $message)
    {
        $subject = $message;
        self::addLogoutLog($user_id, $subject);
    }

    public static function successLog($message)
    {
        $type = 1;
        $subject = $message;
        self::addLog($type, $subject);
    }

    public static function warningLog($message)
    {
        $type = 2;
        $subject = $message;
        self::addLog($type, $subject);
    }

    public static function infoLog($message)
    {
        $type = 3;
        $subject = $message;
        self::addLog($type, $subject);
    }

    public static function logActivityLists()
    {
    	return LogActivityModel::with('user')->where('login', 0)->latest();
    }

    public static function logActivityListsDuty()
    {
    	return LogActivityModel::with('user')->where('login', 1)->latest();
    }

    public static function addLoginLog($type, $subject)
    {
        $log = [];
        $log['type'] = $type;
        $log['login'] = 1;
        $log['login_time'] = Carbon::now();
    	$log['logout_time'] = null;
    	$log['subject'] = $subject;
        $log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Browser::browserFamily().'-'.Browser::browserVersion().'-'.Browser::browserEngine().'-'.Browser::platformName().'-'.Browser::deviceModel();
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	LogActivityModel::create($log);
    }

    public static function addLogoutLog($user_id, $subject)
    {
        $loginActivity = LogActivityModel::where('login', 1)->where('logout_time', null)->where('user_id', $user_id)->where('ip', Request::ip())->where('agent', Browser::browserFamily().'-'.Browser::browserVersion().'-'.Browser::browserEngine().'-'.Browser::platformName().'-'.Browser::deviceModel())->first();
        if ($loginActivity)
        {
            $loginActivity->logout_time = Carbon::now();
            $loginActivity->subject = $subject;
            $loginActivity->save();
        }
    }

    public static function log_activity_destroy_all(){
        $lists = LogActivityModel::where('login', 0)->pluck('id');
        LogActivityModel::destroy($lists);
        return true;
    }

    public static function login_activity_destroy_all(){
        $lists = LogActivityModel::where('login', 1)->pluck('id');
        LogActivityModel::destroy($lists);
        return true;
    }
}
