<?php


namespace App\Controllers;


use App\Models\Post;

class PostController extends Controller
{
    protected $view = 'post';

    public function index() {
        $post = Post::find($_GET['id']);

        $this->set('post', $post);

        $this->render();
    }

    public function create() {
        $this->view = 'create';
        $this->render();
    }

    public function store() {
        $post = new post($_POST);
        try {
            $post->save();
            header("Location: /home");
        } catch(\ValidationException $e) {
            // invalid data provided
            header("Location: /post/create");
        }
    }
}