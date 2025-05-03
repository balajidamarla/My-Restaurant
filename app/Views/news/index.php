<h1><?= esc($title) ?></h1>

<?php if (! empty($news) && is_array($news)): ?>

    <?php foreach ($news as $news_item): ?>
        <h3><?= esc($news_item['title']) ?></h3>
        <div>
            <?= esc($news_item['body']) ?>
        </div>
        <p><a href="<?= base_url()?>news/<?= esc($news_item['slug']) ?>">View article</a></p>
        <?= "<hr>"; ?>
    <?php endforeach ?>


<?php else: ?>
    <h3>No News</h3>
    <p>Unable to find any news for you.</p>
<?php endif ?>