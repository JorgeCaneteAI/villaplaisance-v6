<?php
$pageFilter = $data['page_filter'] ?? '';
$faqRows    = Database::fetchAll(
    "SELECT * FROM vp_faq WHERE lang = ? AND active = 1" . ($pageFilter ? " AND page = ?" : "") . " ORDER BY position ASC",
    $pageFilter ? [$lang ?? 'fr', $pageFilter] : [$lang ?? 'fr']
);
?>
<?php if (!empty($faqRows)): ?>
<section class="block-faq container reveal">
    <h2 class="block-title">Questions fréquentes</h2>
    <dl class="faq-list">
        <?php foreach ($faqRows as $item): ?>
        <div class="faq-item">
            <dt class="faq-question"><?= htmlspecialchars($item['question'] ?? '') ?></dt>
            <dd class="faq-answer"><?= nl2br(htmlspecialchars($item['answer'] ?? '')) ?></dd>
        </div>
        <?php endforeach; ?>
    </dl>
</section>
<?php endif; ?>
