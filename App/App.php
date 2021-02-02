<?php


namespace App;


use App\Controllers\HomeController;

class App
{
    private static ?App $app = null;

    private function __construct()
    {
    }

    /**
     * Create singleton instance
     * @return App
     */
    public static function instance(): App
    {
        if (null == App::$app) {
            App::$app = new App();
        }

        return App::$app;
    }

    /**
     * Bootstrap and run the app
     */
    public function run()
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        unset($uri[0]);

        if ($uri[1] == 'index.php') {
            unset($uri[1]);
        }

        $uri = array_merge([], $uri);

        for ($i = 0; $i < count($uri); $i++) {
            $uri[$i] = $this->stripQueryString($uri[$i]);
        }

        // var_dump($uri);

        if (strlen($uri[0]) < 1) {
            $controller = 'App\\Controllers\\HomeController';
            $view = strlen($uri[0]) > 0 ? $uri[0] : 'index';
        } else {
            $controller = 'App\\Controllers\\' . ucwords($uri[0]) . 'Controller';
            $view = isset($uri[1]) && strlen($uri[1]) > 0 ? $uri[1] : 'index';
        }

        if (!file_exists(dirname(__DIR__) . '/' . str_replace('\\', '/', $controller) . '.php')) {
            $this->show404();
        }

        unset($uri[0]);
        unset($uri[1]);


        $c = new $controller();
        if (false == method_exists($c, $view)) {
            $this->show404();
        } else {
            call_user_func_array([$c, $view], $uri);
        }
    }

    /**
     * Remove query string from a uri
     * @param $var
     * @return string
     */
    private function stripQueryString($var): string
    {
        if (strstr($var, '?')) {
            $var = substr($var, 0, strrpos($var, '?'));
        }
        return $var;
    }

    /**
     * Show the 404 page
     */
    private function show404()
    {
        $c = new HomeController();
        $c->show404();
        exit();
    }
}