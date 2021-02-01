<?php


namespace App\Controllers;


class Controller
{
    private array $props = [];
    protected $view = '';

    public function set($key, $value)
    {
        $this->props[$key] = $value;
    }

    public function get($key)
    {
        return $this->props[$key];
    }

    public function exists($key)
    {
        return isset($props[$key]);
    }

    public function render()
    {
        ob_start();
        require_once "App/Views/_header.php";
        extract($this->props);
        require_once "App/Views/" . $this->view . ".php";
        require_once "App/Views/_footer.php";
        $page = ob_get_contents();
        ob_end_clean();

        echo $page;
    }
}