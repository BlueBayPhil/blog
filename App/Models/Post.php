<?php


namespace App\Models;


use App\Database\DB;

class Post extends Model
{
    public $id;
    public $title;
    public $description;
    public $content;
    public $created_at;

    protected $table = 'posts';

    public function validate(): bool
    {
        if (strlen($this->title) > 100) return false;
        if (strlen($this->description) > 200) return false;

        return true;
    }

    public function comments()
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