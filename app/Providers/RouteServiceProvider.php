<?php

namespace Suitcoda\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Suitcoda\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
        $this->loadRoutePermission();
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }

    public function loadRoutePermission()
    {
        $data = array();
        $exlude = ['debugbar'];
        foreach ($this->app['router']->getRoutes() as $key => $value) {
            $data_key = $value->getName();
            $temp = explode('.', $value->getName());
            $data_key_first_word = $temp[0];
            if ($data_key !== null && !in_array($data_key_first_word, $exlude)) {
                $data_value = str_replace('.', '-', $data_key);
                $data_value = ucfirst($data_value);

                $data[$data_key] = $data_value;
            }
        }
        $this->app['config']->set('permissions', $data);
    }
}
