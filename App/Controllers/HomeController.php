<?php


namespace App\Controllers;


use App\Models\Post;

class HomeController extends Controller
{
    protected string $view = 'home';

    /**
     * Displays a listing of posts for the home page
     */
    public function index()
    {
        $posts = Post::all();

        $this->set('posts', $posts);

        $this->render();
    }

    public function show404() {
        $this->view = '404';
        $this->render();
    }
}