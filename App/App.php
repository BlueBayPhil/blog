<?php


namespace App;


class App
{
    private static ?App $app = null;

    private function __construct()
    {
    }

    public static function instance(): App
    {
        if (null == App::$app) {
            App::$app = new App();
        }

        return App::$app;
    }

    public function run()
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        unset($uri[0]);

        if ($uri[1] == 'index.php') {
            unset($uri[1]);
        }

        $uri = array_merge([], $uri);

        for($i = 0; $i < count($uri); $i++) {
            $uri[$i] = $this->stripQueryString($uri[$i]);
        }

        var_dump($uri);

        if (strlen($uri[0]) < 1) {
            $controller = 'App\\Controllers\\HomeController';
            $view = strlen($uri[0]) > 0 ? $uri[0] : 'index';
        } else {
            $controller = 'App\\Controllers\\' . ucwords($uri[0]) . 'Controller';
            $view = isset($uri[1]) && strlen($uri[1]) > 0 ? $uri[1] : 'index';
        }

        unset($uri[0]);
        unset($uri[1]);

        $c = new $controller();

        call_user_func_array([$c, $view], $uri);
    }

    private function stripQueryString($var) : string
    {
        if(strstr($var, '?')) {
            $var = substr($var, 0, strrpos($var, '?'));
        }
        return $var;
    }
}