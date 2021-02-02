<div class="row">
    <div class="col col-9">
        <h1><?=$post->title;?> <div class="float-right"><a href="/post/edit?post=<?=$post->id;?>" class="btn">Edit</a><a href="/post/delete?post=<?=$post->id;?>" class="btn btn-danger">Delete</a></div></h1>
        <h4 class="text-muted">Written <?=$post->createdAt()->format('jS F Y H:i');?></h4>
        <article>
            <?=nl2br($post->content);?>
        </article>
    </div>
    <div class="col">
        <div class="comments-box">
            <h3>Comments</h3>

            <div class="comments-form">
                <form method="post" action="/comment/store">
                    <input type="hidden" name="post" value="<?=$post->id;?>">
                    <div class="form-group">
                        <label for="commentName">Your Name</label>
                        <input type="text" name="commenter" id="commentName" maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea name="content" id="comment" wrap="hard" rows="3" cols="75"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit">Submit</button>
                    </div>
                </form>
            </div>

            <div class="comments-list">
                <?php foreach($post->comments() as $comment): ?>
                    <div class="comment">
                        <h4><?=$comment->commenter;?> <span><?=$comment->createdAt()->format('jS M Y h:i a');?></span></h4>
                        <p><?=$comment;?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>