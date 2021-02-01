<?php


namespace App\Controllers;


use App\Models\Post;

class HomeController extends Controller
{
    protected $view = 'home';

    public function index()
    {
        $posts = Post::all();

        $this->set('posts', $posts);

        $this->render();
    }
}