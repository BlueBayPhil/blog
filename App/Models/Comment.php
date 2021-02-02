<?php


namespace App\Models;


class Comment extends model
{
    public string $commenter;
    public string $content;
    public string $post_id;
    public string $created_at;

    // protected $table = 'comments';

    /**
     * Returns the Post object that this comment relates to
     * @return Post
     */
    public function post(): Post
    {
        return Post::find($this->post_id);
    }

    /**
     * Tells PHP what to return when using object as a string
     * @return string
     */
    public function __toString(): string
    {
        return $this->content;
    }
}