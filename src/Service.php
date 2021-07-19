<?php

namespace Qubao\ThinkWechat;

use EasyWeChat\MicroMerchant\Application as MicroMerchant;
use EasyWeChat\MiniProgram\Application as MiniProgram;
use EasyWeChat\OfficialAccount\Application as OfficialAccount;
use EasyWeChat\OpenPlatform\Application as OpenPlatform;
use EasyWeChat\OpenWork\Application as OpenWork;
use EasyWeChat\Payment\Application as Payment;
use EasyWeChat\Work\Application as Work;
use think\Service as ThinkService;

class Service extends ThinkService
{
    protected $apps = [
        'official_account' => OfficialAccount::class,
        'payment' => Payment::class,
        'mini_program' => MiniProgram::class,
        'open_platform' => OpenPlatform::class,
        'work' => Work::class,
        'open_work' => OpenWork::class,
        'micro_merchant' => MicroMerchant::class
    ];

    public function register()
    {
        $configDefault = config('wechat.default') ? config('wechat.default') : [];

        foreach ($this->apps as $appName => $app)
        {
            if (!config("wechat.{$appName}"))
            {
                continue;
            }
            $appConfigs = config("wechat.{$appName}");
            foreach($appConfigs as $configName => $appconfig)
            {
                $this->app->bind("wechat.{$appName}.{$configName}", function($config = []) use ($configDefault, $appconfig, $app) {
                    $moduleConfig = array_merge($configDefault, $appconfig, $config);
                    $moduleApp = app($app, ['config'=>$moduleConfig]);
                    if ($configDefault['use_tp_cache'])
                    {
                        $moduleApp->rebind('cache', app(Cache::class));
                    }
                    return $moduleApp;
                });
            }
            if (isset($appConfigs['default']))
            {
                $this->app->bind("wechat.{$appName}", 'wechat.'.$appName.'.default');
            }
        }
    }
}