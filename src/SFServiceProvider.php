<?php
namespace Ptx\Sf;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use hVenus\SFExpressAPI\BSP\RouteService;

class SFServiceProvider extends ServiceProvider
{
        /**
         * Determin is defer.
         *
         * @var bool
         */
    protected $defer = true;

    /**
     * Boot the service.
     *
     * @author yansongda <me@yansongda.cn>
     */
    public function boot()
    {
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                dirname(__DIR__).'/config/sf-express.php' => config_path('sf-express.php'), ],
                'laravel-sf'
            );
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('sf-express');
        }
    }

    /**
     * Regist the service.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__).'/config/sf-express.php', 'sf-express');

        $this->app->singleton('sf.route', function (){
            return new RouteService(app('config')->get('sf-express'));
        });
    }

    /**
     * Get services.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return array
     */
    public function provides()
    {
        return ['sf.route'];
    }
}