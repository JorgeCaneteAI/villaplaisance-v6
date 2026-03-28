<?php declare(strict_types=1); ?>
<?php ob_start(); ?>

<?php foreach ($sections as $section): ?>
    <?php
    $data = $section['data'];
    $blockFile = ROOT . '/app/Views/blocks/' . $section['type'] . '.php';
    if (file_exists($blockFile)) {
        include $blockFile;
    }
    ?>
<?php endforeach; ?>

<?php if (isset($csrf)): ?>
<?php include ROOT . '/app/Views/front/contact-form.php'; ?>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php include ROOT . '/app/Views/front/layout.php'; ?>
