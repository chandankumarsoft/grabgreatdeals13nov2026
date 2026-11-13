<?php

namespace App\Controllers;

use App\Libraries\LegacyCartAdapter;
use App\Libraries\LegacyDatabaseAdapter;
use App\Libraries\LegacyPaginationAdapter;
use App\Libraries\LegacySessionAdapter;
use App\Libraries\LegacyUriAdapter;
use App\Libraries\LegacyViewRenderer;
use App\Models\LegacyBlogModel;
use App\Models\LegacyCategoryModel;
use App\Models\LegacyProductModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class Blog extends BaseController
{
    public function blog(): string
    {
        $blogs = new LegacyBlogModel();
        $offset = $this->pageOffset();
        $total = $blogs->countPublishedBlogs();

        return $this->renderPage(
            'blog',
            'front/blog',
            ['allblogdata' => $blogs->fetchallblogfront(10, $offset)],
            new LegacyPaginationAdapter(base_url('blog'), $total, 10, $offset),
        );
    }

    public function singleBlog(string $slug): string
    {
        $blogs = new LegacyBlogModel();
        $blog = $blogs->blogDataBySlug($slug);

        if ($blog === null) {
            return $this->notFoundPage();
        }

        return $this->renderPage('single-post', 'front/single_post', [
            'slug_data' => $blog,
            'blogid'    => $blog->blog_id,
        ]);
    }

    public function blogByCategory(): string
    {
        $blogs = new LegacyBlogModel();
        $offset = $this->pageOffset();
        $total = db_connect()->table('tbl_blog_category')->countAllResults();

        return $this->renderPage(
            'blog',
            'front/blog_by_category',
            ['allblogdata' => $blogs->allBlogByCategory(5, $offset)],
            new LegacyPaginationAdapter(base_url('blog/category'), $total, 5, $offset),
        );
    }

    public function blogByCategorySlug(string $categorySlug): string
    {
        $blogs = new LegacyBlogModel();

        return $this->renderPage(
            'blog',
            'front/blog_by_category_slug',
            ['allblogdata' => $blogs->allBlogByCategorySlug($categorySlug)],
        );
    }

    public function tagsAll(): string
    {
        $blogs = new LegacyBlogModel();
        $offset = $this->pageOffset();
        $total = db_connect()->table('tbl_blog_tag')->countAllResults();

        return $this->renderPage(
            'blog',
            'front/tags',
            ['allblogdata' => $blogs->allBlogTags(5, $offset)],
            new LegacyPaginationAdapter(base_url('tags'), $total, 5, $offset),
        );
    }

    public function blogByTags(string $tagSlug): string
    {
        return $this->renderPage(
            'blog',
            'front/tagsview',
            ['allblogdata' => (new LegacyBlogModel())->allBlogByTags($tagSlug)],
        );
    }

    public function commentFormSubmit(): ResponseInterface
    {
        $validation = service('validation');
        $validation->setRules([
            'blog_id' => 'required|is_natural_no_zero',
            'name'    => 'required|max_length[100]',
            'email'   => 'required|valid_email|max_length[254]',
            'message' => 'required|max_length[5000]',
        ]);

        if (! $validation->run($this->request->getPost())) {
            $errors = $validation->getErrors();

            return $this->response->setJSON([
                'error'         => true,
                'name_error'    => $this->formatError($errors, 'name'),
                'email_error'   => $this->formatError($errors, 'email'),
                'message_error' => $this->formatError($errors, 'message'),
            ]);
        }

        $blogId = (int) $this->request->getPost('blog_id');
        $blogs = new LegacyBlogModel();
        if (! $blogs->publishedBlogExists($blogId)) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Blog post not found.']);
        }

        $this->insertComment([
            'comment_blog_id' => $blogId,
            'comment_name'    => $this->request->getPost('name'),
            'comment_email'   => $this->request->getPost('email'),
            'comment_content' => $this->request->getPost('message'),
        ]);

        return $this->response->setJSON([
            'success' => '<div class="alert alert-success">Thank you for Commenting</div>',
        ]);
    }

    public function replyCommentFormSubmit(): ResponseInterface
    {
        $validation = service('validation');
        $validation->setRules([
            'replyblog_id'        => 'required|is_natural_no_zero',
            'replycommentblog_id' => 'required|is_natural_no_zero',
            'replyname'           => 'required|max_length[100]',
            'replyemail'          => 'required|valid_email|max_length[254]',
            'replymessage'        => 'required|max_length[5000]',
        ]);

        if (! $validation->run($this->request->getPost())) {
            $errors = $validation->getErrors();

            return $this->response->setJSON([
                'error'           => true,
                'name_error'      => $this->formatError($errors, 'replyname'),
                'email_error'     => $this->formatError($errors, 'replyemail'),
                'message_error'   => $this->formatError($errors, 'replymessage'),
            ]);
        }

        $blogId = (int) $this->request->getPost('replyblog_id');
        $commentId = (int) $this->request->getPost('replycommentblog_id');
        $blogs = new LegacyBlogModel();
        if (! $blogs->publishedBlogExists($blogId) || ! $blogs->commentExists($blogId, $commentId)) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Blog comment not found.']);
        }

        $this->insertComment([
            'reply_blog_comment_id' => $blogId,
            'reply_comment_id'      => $commentId,
            'comment_name'          => $this->request->getPost('replyname'),
            'comment_email'         => $this->request->getPost('replyemail'),
            'comment_content'       => $this->request->getPost('replymessage'),
        ]);

        return $this->response->setJSON([
            'replysuccess' => '<div class="alert alert-success">Thank you for Commenting</div>',
        ]);
    }

    public function likeCommentedDataInsert(): ResponseInterface
    {
        $type = (int) $this->request->getPost('type_of_data');
        if (! in_array($type, [1, 2], true)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid reaction type.']);
        }

        $result = (new LegacyBlogModel())->insertLikeData(
            (string) $this->request->getPost('likecommentid'),
            (string) $this->request->getPost('blogid'),
            $type,
        );

        if ($result === 0) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Comment not found.']);
        }

        return $this->response->setJSON($result === 1 ? ['like' => 'success'] : ['dislike' => 'success']);
    }

    public function likeBlog(): ResponseInterface
    {
        $type = (int) $this->request->getPost('type_of_data');
        if (! in_array($type, [1, 2], true)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid reaction type.']);
        }

        $result = (new LegacyBlogModel())->insertBlogLikeData(
            (string) $this->request->getPost('blogid'),
            $type,
        );

        if ($result === 0) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Blog post not found.']);
        }

        return $this->response->setJSON($result === 1 ? ['like' => 'success'] : ['dislike' => 'success']);
    }

    private function insertComment(array $comment): void
    {
        if (! (new LegacyBlogModel())->insertComment($comment)) {
            throw new RuntimeException('Unable to save the blog comment.');
        }
    }

    private function formatError(array $errors, string $field): string
    {
        return isset($errors[$field]) ? '<p>' . esc($errors[$field]) . '</p>' : '';
    }

    private function pageOffset(): int
    {
        $page = $this->request->getGet('page');

        return is_numeric($page) ? max(0, (int) $page) : 0;
    }

    private function notFoundPage(): string
    {
        $this->response->setStatusCode(404);

        return $this->renderPage('404', 'front/404');
    }

    private function renderPage(
        string $page,
        string $contentView,
        array $data = [],
        ?LegacyPaginationAdapter $pagination = null,
    ): string {
        $data['page'] = $page;
        $services = $pagination === null ? [] : ['pagination' => $pagination];
        $renderer = $this->legacyRenderer($services);
        $output = '';

        foreach ([
            ['front/header', $data],
            ['front/category', []],
            ['front/breadcrumbs', []],
            [$contentView, $data],
            ['front/footer', []],
        ] as [$view, $viewData]) {
            $output .= $renderer->render($view, $viewData);
        }

        return $output;
    }

    private function legacyRenderer(array $extraServices = []): LegacyViewRenderer
    {
        helper('legacy_storefront');
        helper('form');
        $session = new LegacySessionAdapter(service('session'));

        return new LegacyViewRenderer('frontend', array_replace([
            'session'       => $session,
            'uri'           => new LegacyUriAdapter(service('uri')),
            'cart'          => new LegacyCartAdapter($session),
            'db'            => new LegacyDatabaseAdapter(db_connect()),
            'CategoryModel' => new LegacyCategoryModel(),
            'BlogModel'     => new LegacyBlogModel(),
            'ProductModel'  => new LegacyProductModel(),
            'pagination'    => new LegacyPaginationAdapter('', 0, 10, 0),
        ], $extraServices));
    }
}
