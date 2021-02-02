<?php


namespace App\Controllers;


use App\Models\Post;

class PostController extends Controller
{
    protected string $view = 'post';

    /**
     * Displays a specific post
     */
    public function index() {
        $post = Post::find($_GET['id']);

        $this->set('post', $post);

        $this->render();
    }

    /**
     * Displays the editor view for creating a new post
     */
    public function create() {
        $this->view = 'editor';
        $this->set('form_action', '/post/store');
        $this->render();
    }

    /**
     * Processes the request to store a post
     */
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

    /**
     * Displays the editor view for editing an existing post
     */
    public function edit() {
        $this->set('post', Post::find($_GET['post']));
        $this->set('form_action', '/post/store');
        $this->view = 'editor';

        $this->render('create');
    }

    /**
     * Processes the request to delete a post
     */
    public function delete() {
        $post = Post::find($_GET['post']);
        $post->delete();

        header("Location: /home");
    }
}