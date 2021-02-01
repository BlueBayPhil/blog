<h2>Create New Post</h2>
<form method="post" action="/post/store">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" maxlength="100" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="description">Caption</label>
        <textarea name="description" id="description" rows="2" cols="75" wrap="soft"></textarea>
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea name="content" id="content" rows="5" cols="75" wrap="hard"></textarea>
    </div>
    <div class="form-group">
        <button type="submit">Submit</button>
    </div>
</form>