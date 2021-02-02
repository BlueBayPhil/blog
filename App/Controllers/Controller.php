<?php


namespace App\Controllers;


class Controller
{
    /**
     * The properties to be extracted into the view
     * @var array
     */
    private array $props = [];

    /**
     * The view file to display
     * @var string
     */
    protected string $view = '';

    /**
     * Sets a param in the view
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->props[$key] = $value;
    }

    /**
     * Gets a previously set param in the view
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->props[$key];
    }

    /**
     * Checks if a param has been set in the view
     * @param $key
     * @return bool
     */
    public function exists($key)
    {
        return isset($props[$key]);
    }

    /**
     * Renders the view on screen
     */
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