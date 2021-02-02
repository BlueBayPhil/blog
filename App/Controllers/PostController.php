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
        $this->view = 'editor';
        $this->set('form_action', '/post/store');
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

    public function edit() {
        $this->set('post', Post::find($_GET['post']));
        $this->set('form_action', '/post/store');
        $this->view = 'editor';

        $this->render('create');
    }

    public function delete() {
        $post = Post::find($_GET['post']);
        $post->delete();

        header("Location: /home");
    }
}