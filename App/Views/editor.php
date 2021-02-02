<h2>Create New Post</h2>
<form method="post" action="<?= $form_action; ?>">
    <input type="hidden" name="id" value="<?=$post->id ?? ''; ?>">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" placeholder="Your fantastic post title..." value="<?= $post->title ?? ''; ?>"
               id="title" maxlength="100" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="description">Caption</label>
        <textarea name="description" id="description" rows="2" cols="75"
                  placeholder="Introduce your post to the world..."
                  wrap="soft"><?= $post->description ?? ''; ?></textarea>
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea name="content" id="content" placeholder="Write with freedom..." rows="5" cols="75"
                  wrap="hard"><?= $post->content ?? ''; ?></textarea>
    </div>
    <div class="form-group">
        <button type="submit">Submit</button>
    </div>
</form>