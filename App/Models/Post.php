<?php


namespace App\Models;


use App\Database\DB;

class Post extends Model
{
    public string $title;
    public string $description;
    public string $content;
    public string $created_at;

    protected string $table = 'posts';

    /**
     * Validate the provided data
     * @return bool
     */
    public function validate(): bool
    {
        if (strlen($this->title) > 100) return false;
        if (strlen($this->description) > 200) return false;

        return true;
    }

    /**
     * Get all the Comment objects for this post
     * @return array
     */
    public function comments() : array
    {
        $return = [];
        $stmt = DB::instance()->prepare("SELECT * FROM comments WHERE post_id=?");
        $stmt->bind_param('s', $this->id);

        $stmt->execute();
        $result = $stmt->get_result();

        while (null != ($row = $result->fetch_assoc())) {
            $return[] = new Comment($row);
        }


        return $return;
    }

    /**
     * Delete the resource. Overridden parent method to delete related comments
     * @return bool
     */
    public function delete(): bool
    {
        $comments = $this->comments();
        if (count($comments) > 0) {
            foreach ($comments as $comment) {
                $comment->delete();
            }
        }

        return parent::delete();
    }
}