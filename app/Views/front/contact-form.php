<section class="block-contact container reveal">
    <?php if ($sent ?? false): ?>
    <div class="contact-success" role="alert">
        <p><?= t('contact.succes') ?></p>
    </div>
    <?php else: ?>
    <form class="contact-form" method="post" action="/contact/envoyer" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf ?? '') ?>">

        <div class="form-group">
            <label for="contact-name"><?= t('contact.nom') ?></label>
            <input type="text" id="contact-name" name="name" autocomplete="name" required>
        </div>

        <div class="form-group">
            <label for="contact-email"><?= t('contact.email') ?></label>
            <input type="email" id="contact-email" name="email" autocomplete="email" required>
        </div>

        <div class="form-group">
            <label for="contact-message"><?= t('contact.message') ?></label>
            <textarea id="contact-message" name="message" rows="6" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary"><?= t('contact.envoyer') ?></button>
    </form>
    <?php endif; ?>
</section>
