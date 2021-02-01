<?php


namespace App\Models;


class Comment extends model
{
    public $commenter;
    public $content;
    public $post_id;
    public $created_at;

    // protected $table = 'comments';

    public function post(): Post
    {
        return Post::find($this->post_id);
    }

    public function __toString()
    {
        return $this->content;
    }
}