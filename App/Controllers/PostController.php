<?php


namespace App\Controllers;


use App\Exceptions\ModelNotFoundException;
use App\Models\Post;

class PostController extends Controller
{
    protected string $view = 'post';

    /**
     * Displays a specific post
     */
    public function index() {
        try {
            $post = Post::find($_GET['id']);

            $this->set('post', $post);

            $this->render();
        } catch(ModelNotFoundException $e) {
            $this->view = '404';
            $this->render();
        }

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
        if(strlen($_POST['id']) < 1) {
            unset($_POST['id']);
        }
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
        try {
            $this->set('post', Post::find($_GET['post']));
            $this->set('form_action', '/post/store');
            $this->view = 'editor';

            $this->render('create');
        } catch(ModelNotFoundException $e) {
            $this->view = '404';
            $this->render();
        }

    }

    /**
     * Processes the request to delete a post
     */
    public function delete() {
        try {
            $post = Post::find($_GET['post']);
            $post->delete();
        } catch(ModelNotFoundException $e) {
            // Dont really care.
        }


        header("Location: /home");
    }
}