<?php
$type    = $data['type'] ?? 'journal';
$max     = (int)($data['max'] ?? 3);
$articles = Database::fetchAll(
    "SELECT * FROM vp_articles WHERE type = ? AND status = 'published' AND lang = ? ORDER BY created_at DESC LIMIT {$max}",
    [$type, $lang ?? 'fr']
);
$baseUrl = $type === 'journal' ? navUrl('journal', $lang ?? 'fr') : navUrl('sur-place', $lang ?? 'fr');
?>
<?php if (!empty($articles)): ?>
<section class="block-articles container reveal">
    <div class="articles-grid">
        <?php foreach ($articles as $art): ?>
        <article class="article-card">
            <?php
            $content_data = json_decode($art['content'] ?? '{}', true);
            $cover = $art['cover_image'] ?? '';
            ?>
            <?php if ($cover): ?>
            <figure class="article-card-img">
                <img src="/assets/img/<?= htmlspecialchars($cover) ?>"
                     alt="<?= htmlspecialchars($art['title'] ?? '') ?>"
                     loading="lazy">
            </figure>
            <?php endif; ?>
            <div class="article-card-body">
                <?php if (!empty($art['created_at'])): ?>
                <time class="article-date"><?= date('j F Y', strtotime($art['created_at'])) ?></time>
                <?php endif; ?>
                <h3 class="article-card-title">
                    <a href="<?= rtrim($baseUrl, '/') ?>/<?= htmlspecialchars($art['slug'] ?? '') ?>">
                        <?= htmlspecialchars($art['title'] ?? '') ?>
                    </a>
                </h3>
                <?php if (!empty($art['excerpt'])): ?>
                <p class="article-card-excerpt"><?= htmlspecialchars($art['excerpt']) ?></p>
                <?php endif; ?>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
