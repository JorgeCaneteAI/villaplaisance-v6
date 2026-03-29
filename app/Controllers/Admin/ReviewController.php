<?php
declare(strict_types=1);

namespace Controllers\Admin;

class ReviewController extends AdminBaseController
{
    public function index(): void
    {
        $this->requireAuth();

        $reviews = \Database::fetchAll(
            "SELECT * FROM vp_reviews ORDER BY
             FIELD(platform,'airbnb','booking','google','direct'),
             FIELD(offer,'bb','villa','both'),
             id DESC"
        );

        $flash = $this->getFlash();

        $this->render('admin/reviews/index', [
            'pageTitle' => 'Avis clients',
            'reviews'   => $reviews,
            'flash'     => $flash,
        ]);
    }

    public function toggleFeatured(int $id): void
    {
        $this->requireAuth();
        $row = \Database::fetchOne("SELECT featured FROM vp_reviews WHERE id = ?", [$id]);
        if ($row) {
            \Database::update('vp_reviews', ['featured' => $row['featured'] ? 0 : 1], 'id = ?', [$id]);
        }
        $this->redirect('/admin/avis');
    }

    public function toggleCarousel(int $id): void
    {
        $this->requireAuth();
        $row = \Database::fetchOne("SELECT home_carousel FROM vp_reviews WHERE id = ?", [$id]);
        if ($row) {
            \Database::update('vp_reviews', ['home_carousel' => $row['home_carousel'] ? 0 : 1], 'id = ?', [$id]);
        }
        $this->redirect('/admin/avis');
    }

    public function toggleStatus(int $id): void
    {
        $this->requireAuth();
        $row = \Database::fetchOne("SELECT status FROM vp_reviews WHERE id = ?", [$id]);
        if ($row) {
            $new = $row['status'] === 'published' ? 'hidden' : 'published';
            \Database::update('vp_reviews', ['status' => $new], 'id = ?', [$id]);
        }
        $this->redirect('/admin/avis');
    }

    public function delete(int $id): void
    {
        $this->requireAuth();
        \Database::delete('vp_reviews', 'id = ?', [$id]);
        $this->flash('success', 'Avis supprimé.');
        $this->redirect('/admin/avis');
    }
}
