<?php
namespace Ptx\SF\Facades;

use Illuminate\Support\Facades\Facade;

class SF extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'sf.route';
    }

    public static function route()
    {
        return app('sf.route');
    }

    public static function order()
    {
        return app('sf.order');
    }
}