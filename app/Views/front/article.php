<?php declare(strict_types=1); ?>
<?php
$title   = htmlspecialchars($article['title'] ?? '');
$content_data = json_decode($article['content'] ?? '{}', true);
$body    = $content_data['body'] ?? ($article['content'] ?? '');
$cover   = $article['cover_image'] ?? '';
$dateRaw = $article['published_at'] ?? $article['created_at'] ?? '';
$date    = $dateRaw ? date('j F Y', strtotime($dateRaw)) : '';
$type    = $article['type'] ?? 'journal';
$backUrl = $type === 'journal' ? navUrl('journal', $lang ?? 'fr') : navUrl('sur-place', $lang ?? 'fr');
$backLabel = $type === 'journal' ? t('nav.journal') : t('nav.sur_place');
?>
<?php ob_start(); ?>

<article class="article-single container reveal">
    <a href="<?= $backUrl ?>" class="article-back">&larr; <?= $backLabel ?></a>

    <?php if ($cover): ?>
    <figure class="article-cover">
        <img src="/assets/img/<?= htmlspecialchars($cover) ?>" alt="<?= $title ?>" loading="lazy">
    </figure>
    <?php endif; ?>

    <header class="article-header">
        <?php if ($date): ?><time class="article-date"><?= $date ?></time><?php endif; ?>
        <h1><?= $title ?></h1>
    </header>

    <div class="article-body prose-content">
        <?= $body ?>
    </div>
</article>

<?php $content = ob_get_clean(); ?>
<?php include ROOT . '/app/Views/front/layout.php'; ?>
