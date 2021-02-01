<?php if (count($posts) < 1): ?>
    <h3>No posts have been created.</h3>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <article>
            <h3><a href="/post?id=<?=$post->id;?>"><?= $post->title; ?></a></h3>
            <p><?= $post->description ?: substr($post->content, 0, 200); ?></p>
        </article>
    <?php endforeach; ?>
<?php endif; ?>