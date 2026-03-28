<section class="block-galerie reveal">
    <?php if (!empty($data['title'])): ?>
    <h2 class="block-title container"><?= htmlspecialchars($data['title']) ?></h2>
    <?php endif; ?>
    <?php if (!empty($data['images'])): ?>
    <div class="galerie-grid" role="list">
        <?php foreach ($data['images'] as $img): ?>
        <?php if (empty(trim($img))) continue; ?>
        <figure class="galerie-item" role="listitem">
            <img src="/assets/img/<?= htmlspecialchars(trim($img)) ?>"
                 alt=""
                 loading="lazy"
                 class="galerie-img">
        </figure>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>
