<section class="block-tableau container reveal">
    <?php if (!empty($data['title'])): ?>
    <h2 class="block-title"><?= htmlspecialchars($data['title']) ?></h2>
    <?php endif; ?>
    <?php if (!empty($data['rows'])): ?>
    <table class="tableau">
        <tbody>
            <?php foreach ($data['rows'] as $row): ?>
            <?php if (empty($row['label'])) continue; ?>
            <tr>
                <th scope="row"><?= htmlspecialchars($row['label']) ?></th>
                <td><?= htmlspecialchars($row['value'] ?? '') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</section>
