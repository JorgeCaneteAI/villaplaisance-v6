<?php
declare(strict_types=1);

namespace Controllers\Admin;

class ArticleController extends AdminBaseController
{
    // ── Liste ──────────────────────────────────────────────────────────────────
    public function index(): void
    {
        $this->requireAuth();

        $filter = $_GET['type'] ?? '';
        $sql    = "SELECT * FROM vp_articles WHERE lang = 'fr'";
        $params = [];
        if (in_array($filter, ['journal', 'sur-place'], true)) {
            $sql    .= " AND type = ?";
            $params[] = $filter;
        }
        $sql .= " ORDER BY type ASC, published_at DESC";

        $articles = \Database::fetchAll($sql, $params);

        $this->render('admin/articles/index', [
            'pageTitle' => 'Articles',
            'articles'  => $articles,
            'filter'    => $filter,
            'flash'     => $this->getFlash(),
        ]);
    }

    // ── Formulaire création ────────────────────────────────────────────────────
    public function create(): void
    {
        $this->requireAuth();
        $this->render('admin/articles/form', [
            'pageTitle' => 'Nouvel article',
            'article'   => null,
            'errors'    => [],
        ]);
    }

    // ── Enregistrement ────────────────────────────────────────────────────────
    public function store(): void
    {
        $this->requireAuth();
        if (!$this->verifyCsrf()) {
            $this->flash('error', 'Token CSRF invalide.');
            $this->redirect('/admin/articles/nouveau');
        }

        $data   = $this->collectPost();
        $errors = $this->validate($data);

        if ($errors) {
            $this->render('admin/articles/form', [
                'pageTitle' => 'Nouvel article',
                'article'   => $data,
                'errors'    => $errors,
            ]);
            return;
        }

        $data['slug'] = $this->resolveSlug($data['slug'] ?: $this->slugify($data['title']), null);
        \Database::insert('vp_articles', $data);
        $this->flash('success', 'Article créé.');
        $this->redirect('/admin/articles');
    }

    // ── Formulaire édition ─────────────────────────────────────────────────────
    public function edit(int $id): void
    {
        $this->requireAuth();
        $article = \Database::fetchOne("SELECT * FROM vp_articles WHERE id = ?", [$id]);
        if (!$article) { $this->redirect('/admin/articles'); }

        // Décoder le contenu JSON pour l'édition
        $decoded = json_decode($article['content'] ?? '{}', true);
        $article['body'] = $decoded['body'] ?? '';

        $this->render('admin/articles/form', [
            'pageTitle' => 'Modifier l\'article',
            'article'   => $article,
            'errors'    => [],
        ]);
    }

    // ── Mise à jour ────────────────────────────────────────────────────────────
    public function update(int $id): void
    {
        $this->requireAuth();
        if (!$this->verifyCsrf()) {
            $this->flash('error', 'Token CSRF invalide.');
            $this->redirect("/admin/articles/{$id}/modifier");
        }

        $existing = \Database::fetchOne("SELECT * FROM vp_articles WHERE id = ?", [$id]);
        if (!$existing) { $this->redirect('/admin/articles'); }

        $data   = $this->collectPost();
        $errors = $this->validate($data);

        if ($errors) {
            $data['id']   = $id;
            $data['body'] = $_POST['body'] ?? '';
            $this->render('admin/articles/form', [
                'pageTitle' => 'Modifier l\'article',
                'article'   => $data,
                'errors'    => $errors,
            ]);
            return;
        }

        $data['slug'] = $this->resolveSlug($data['slug'] ?: $this->slugify($data['title']), $id);
        \Database::update('vp_articles', $data, 'id = ?', [$id]);
        $this->flash('success', 'Article mis à jour.');
        $this->redirect('/admin/articles');
    }

    // ── Suppression ───────────────────────────────────────────────────────────
    public function delete(int $id): void
    {
        $this->requireAuth();
        if (!$this->verifyCsrf()) {
            $this->flash('error', 'Token CSRF invalide.');
            $this->redirect('/admin/articles');
        }
        \Database::delete('vp_articles', 'id = ?', [$id]);
        $this->flash('success', 'Article supprimé.');
        $this->redirect('/admin/articles');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────
    private function collectPost(): array
    {
        $body = trim($_POST['body'] ?? '');
        return [
            'type'          => in_array($_POST['type'] ?? '', ['journal', 'sur-place'], true) ? $_POST['type'] : 'journal',
            'category'      => trim($_POST['category'] ?? ''),
            'slug'          => $this->slugify(trim($_POST['slug'] ?? '')),
            'lang'          => 'fr',
            'title'         => trim($_POST['title'] ?? ''),
            'excerpt'       => trim($_POST['excerpt'] ?? ''),
            'content'       => json_encode(['body' => $body], JSON_UNESCAPED_UNICODE),
            'meta_title'    => trim($_POST['meta_title'] ?? ''),
            'meta_desc'     => trim($_POST['meta_desc'] ?? ''),
            'meta_keywords' => trim($_POST['meta_keywords'] ?? ''),
            'gso_desc'      => trim($_POST['gso_desc'] ?? ''),
            'og_image'      => trim($_POST['og_image'] ?? ''),
            'cover_image'   => trim($_POST['cover_image'] ?? ''),
            'status'        => in_array($_POST['status'] ?? '', ['published', 'draft'], true) ? $_POST['status'] : 'draft',
            'published_at'  => !empty($_POST['published_at']) ? $_POST['published_at'] : date('Y-m-d H:i:s'),
        ];
    }

    private function validate(array $data): array
    {
        $errors = [];
        if (empty($data['title']))   { $errors['title']   = 'Le titre est obligatoire.'; }
        if (empty($data['excerpt'])) { $errors['excerpt'] = 'L\'extrait est obligatoire.'; }
        return $errors;
    }

    private function resolveSlug(string $base, ?int $excludeId): string
    {
        $slug    = $base;
        $counter = 1;
        while (true) {
            $sql    = "SELECT id FROM vp_articles WHERE slug = ?";
            $params = [$slug];
            if ($excludeId !== null) {
                $sql    .= " AND id != ?";
                $params[] = $excludeId;
            }
            if (!\Database::fetchOne($sql, $params)) break;
            $slug = $base . '-' . $counter++;
        }
        return $slug;
    }
}
