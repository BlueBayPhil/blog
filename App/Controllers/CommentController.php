<?php


namespace App\Controllers;


use App\Models\Comment;

class CommentController extends Controller
{

    /**
     * Processes a request to store a new comment
     */
    public function store() {
        $data = $_POST;
        $data['post_id'] = $data['post'];
        unset($data['post']);
        $comment = new Comment($data);
        try {
            $comment->save();
        } catch(\ValidationException $e) {
            die("Oh noes!");
        }

        header("Location: /post?id=" . $_POST['post']);
    }
}